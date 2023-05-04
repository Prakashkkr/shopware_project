<?php declare(strict_types=1);

namespace Shopware\Tests\Migration\Core\V6_4;

use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\Log\Package;
use Shopware\Core\Framework\Test\TestCaseBase\KernelLifecycleManager;
use Shopware\Core\Migration\Migration1675827655UpdateVATPatternForCyprusCountry;

/**
 * @internal
 *
 * @covers \Shopware\Core\Migration\V6_4\Migration1675827655UpdateVATPatternForCyprusCountry
 */
#[Package('customer-order')]
class Migration1675827655UpdateVATPatternForCyprusCountryTest extends TestCase
{
    private Connection $connection;

    protected function setUp(): void
    {
        $this->connection = KernelLifecycleManager::getConnection();
        $this->prepare();
    }

    public function testGetPatternForCyprusCountry(): void
    {
        $vatPattern = (string) $this->connection->fetchOne(
            'SELECT vat_id_pattern FROM country WHERE iso = :iso;',
            ['iso' => 'CY']
        );

        static::assertSame($vatPattern, '(CY)?[0-9]{8}L');

        $migration = new Migration1675827655UpdateVATPatternForCyprusCountry();
        $migration->update($this->connection);

        $vatPattern = (string) $this->connection->fetchOne(
            'SELECT vat_id_pattern FROM country WHERE iso = :iso;',
            ['iso' => 'CY']
        );

        static::assertSame($vatPattern, '(CY)?[0-9]{8}[A-Z]{1}');
    }

    private function prepare(): void
    {
        $this->connection->executeStatement(
            'UPDATE country SET vat_id_pattern = :pattern WHERE iso = :iso;',
            ['pattern' => '(CY)?[0-9]{8}L', 'iso' => 'CY']
        );
    }
}
