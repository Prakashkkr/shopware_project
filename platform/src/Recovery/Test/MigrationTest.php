<?php declare(strict_types=1);

namespace Shopware\Recovery\Test;

use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\Migration\MigrationSource;
use Shopware\Recovery\Common\IOHelper;
use Shopware\Recovery\Update\Console\Application as UpdateApplication;
use Shopware\Recovery\Update\DependencyInjection\Container;
use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use Slim\Http\Uri;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class MigrationTest extends TestCase
{
    /**
     * @var array
     */
    private $config;

    public function setUp(): void
    {
        $this->config = require __DIR__ . '/../test_config.php';
        require_once __DIR__ . '/../autoload.php';
    }

    public function tearDown(): void
    {
        $this->dropDatabase();
    }

    public function testUpdateContainerMigrationSourcesNew(): void
    {
        $config = require __DIR__ . '/../Update/config/config.php';
        /** @var Container $container */
        $container = new Container(new \Slim\Container(), $config);

        /** @var MigrationSource[] $sources */
        $sources = $container->get('migration.sources');

        static::assertCount(3, $sources);
        static::assertSame('core', $sources[0]->getName());
        static::assertEmpty($sources[0]->getSourceDirectories());

        static::assertSame('core.V6_3', $sources[1]->getName());
        static::assertNotEmpty($sources[1]->getSourceDirectories());

        static::assertSame('core.V6_4', $sources[2]->getName());
    }

    public function testMigrationDuringUpdate(): void
    {
        $this->setUpUpdateGlobals();
        /** @var App $app */
        $app = require __DIR__ . '/../Update/src/app.php';
        $app->callMiddlewareStack($this->requestFactory('GET', '/'), new Response());
        $this->changeMigrationSource($app);

        for ($i = 0; $i < 2; ++$i) {
            $response = $app(
                $this->requestFactory('GET', '/applyMigrations', ['offset' => 0, 'total' => \PHP_INT_MAX, 'modus' => 'update']),
                new Response()
            );
            $content = (string) $response->getBody();
            static::assertStringContainsString('"valid": true,', $content);

            $response = $app(
                $this->requestFactory('GET', '/applyMigrations', ['offset' => 0, 'total' => \PHP_INT_MAX, 'modus' => 'update_destructive']),
                new Response()
            );
            $content = (string) $response->getBody();
            static::assertStringContainsString('"valid": true,', $content);
        }

        $this->assertTestMigrationsWereExecuted($app);
    }

    public function testMigrationsDuringCLIUpdate(): void
    {
        $this->setUpUpdateGlobals();

        $app = new UpdateApplication('testing');
        $command = $app->get('update');

        $this->changeMigrationSource($app);

        \Closure::bind(function () use ($command, $app): void {
            $command->container = $app->getContainer();

            $command->IOHelper = new IOHelper(
                new ArrayInput([]),
                new NullOutput(),
                new QuestionHelper()
            );

            $command->migrateDatabase('update');
            $command->migrateDatabase('foo');
        }, $command, $command)->call($command);

        $this->assertTestMigrationsWereExecuted($app);
    }

    public function requestFactory(string $method, string $uri, array $params = []): Request
    {
        $parts = [];
        foreach ($params as $name => $value) {
            $parts[] = $name . '=' . $value;
        }

        $uri .= '?' . implode('&', $parts);
        $env = Environment::mock();
        $uri = Uri::createFromString($uri);
        $headers = Headers::createFromEnvironment($env);
        $serverParams = $env->all();
        $body = new RequestBody();
        $uploadedFiles = UploadedFile::createFromEnvironment($env);

        return new Request($method, $uri, $headers, [], $serverParams, $body, $uploadedFiles);
    }

    /**
     * @param App|UpdateApplication $app
     */
    protected function changeMigrationSource($app): void
    {
        $source = new MigrationSource(
            'core',
            [__DIR__ . '/_migrations' => 'Shopware\\Recovery\\Test\\_migrations']
        );

        if ($app instanceof App) {
            $app->getContainer()['migration.source'] = $source;

            return;
        }

        if ($app instanceof UpdateApplication) {
            $app->getContainer()->set('migration.source', $source);

            return;
        }

        throw new \RuntimeException('Not working with ' . \get_class($app));
    }

    protected function dropDatabase(): void
    {
        @`mysql -u app -papp -h mysql -e "DROP DATABASE IF EXISTS {$this->config['dbname']}"`;
    }

    protected function createDatabase(): void
    {
        $path = SW_PATH;

        $this->dropDatabase();
        @`mysql -u app -papp -h mysql -e "CREATE DATABASE {$this->config['dbname']}"`;
        @`mysql -u app -papp -h mysql {$this->config['dbname']} < {$path}/vendor/shopware/platform/src/Core/schema.sql`;
    }

    protected function setUpUpdateGlobals(): void
    {
        // :D an the update
        if (!\defined('UPDATE_IS_MANUAL')) {
            \define('UPDATE_IS_MANUAL', true);
            \define('UPDATE_FILES_PATH', null);
            \define('UPDATE_ASSET_PATH', __DIR__ . '/_update-assets');
            \define('UPDATE_META_FILE', null);
        }

        $_SERVER['REMOTE_ADDR'] = '6.6.6';

        $this->createDatabase();
        $_ENV['DATABASE_URL'] = $this->getDsn();
        putenv('DATABASE_URL=' . $this->getDsn());
    }

    protected function assertTestMigrationsWereExecuted($app): void
    {
        $container = $app->getContainer();

        if (method_exists($container, 'get')) {
            /** @var \PDO $pdo */
            $pdo = $app->getContainer()->get('db');
        } else {
            /** @var \PDO $pdo */
            $pdo = $app->getContainer()['db'];
        }

        static::assertCount(6, $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN));
    }

    private function getDsn()
    {
        return 'mysql://'
            . $this->config['dbuser']
            . ':'
            . $this->config['dbpassword']
            . '@'
            . $this->config['dbhost']
            . ':'
            . $this->config['dbport']
            . '/'
            . $this->config['dbname'];
    }
}
