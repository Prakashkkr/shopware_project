<?php declare(strict_types=1);

namespace Shopware\Tests\Unit\Core\Content\Product\Cleanup;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Content\Media\DeleteNotUsedMediaService;
use Shopware\Core\Content\Product\Aggregate\ProductDownload\ProductDownloadDefinition;
use Shopware\Core\Content\Product\Cleanup\CleanupUnusedDownloadMediaTask;
use Shopware\Core\Content\Product\Cleanup\CleanupUnusedDownloadMediaTaskHandler;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\Struct\ArrayStruct;

/**
 * @internal
 *
 * @covers \Shopware\Core\Content\Product\Cleanup\CleanupUnusedDownloadMediaTaskHandler
 */
class CleanupUnusedDownloadMediaTaskHandlerTest extends TestCase
{
    /**
     * @var MockObject|DeleteNotUsedMediaService
     */
    private $deleteMediaService;

    private CleanupUnusedDownloadMediaTaskHandler $handler;

    public function setUp(): void
    {
        $this->deleteMediaService = $this->createMock(DeleteNotUsedMediaService::class);

        $this->handler = new CleanupUnusedDownloadMediaTaskHandler(
            $this->createMock(EntityRepositoryInterface::class),
            $this->deleteMediaService
        );
    }

    public function testGetHandledMessages(): void
    {
        static::assertEquals([CleanupUnusedDownloadMediaTask::class], $this->handler::getHandledMessages());
    }

    public function testRun(): void
    {
        $context = Context::createDefaultContext();

        $context->addExtension(
            DeleteNotUsedMediaService::RESTRICT_DEFAULT_FOLDER_ENTITIES_EXTENSION,
            new ArrayStruct([ProductDownloadDefinition::ENTITY_NAME])
        );

        $this->deleteMediaService
            ->expects(static::once())
            ->method('deleteNotUsedMedia')
            ->with($context);

        $this->handler->run();
    }
}
