<?php declare(strict_types=1);

namespace Shopware\Core\Content\Media\DataAbstractionLayer;

use Shopware\Core\Content\Media\Subscriber\MediaDeletionSubscriber;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityWrittenContainerEvent;
use Shopware\Core\Framework\DataAbstractionLayer\Search\AggregationResult\AggregationResultCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearchResult;
use Shopware\Core\Framework\DataAbstractionLayer\Search\IdSearchResult;
use Shopware\Core\Framework\DataAbstractionLayer\Write\CloneBehavior;
use Shopware\Core\Framework\Feature;
use Shopware\Core\Framework\Log\Package;

/**
 * @deprecated tag:v6.5.0 - reason:remove-decorator - Will be removed
 */
#[Package('core')]
class MediaThumbnailRepositoryDecorator implements EntityRepositoryInterface
{
    /**
     * @deprecated tag:v6.5.0 - Use \Shopware\Core\Content\Media\DataAbstractionLayer\MediaDeletionSubscriber::SYNCHRONE_FILE_DELETE instead
     */
    public const SYNCHRONE_FILE_DELETE = MediaDeletionSubscriber::SYNCHRONE_FILE_DELETE;

    private EntityRepositoryInterface $innerRepo;

    /**
     * @internal
     */
    public function __construct(EntityRepositoryInterface $innerRepo)
    {
        $this->innerRepo = $innerRepo;
    }

    public function delete(array $ids, Context $context): EntityWrittenContainerEvent
    {
        $mapped = [];
        foreach ($ids as $id) {
            if (!\is_array($id)) {
                $id = ['id' => $id];
                Feature::triggerDeprecationOrThrow('v6.5.0.0', 'Thumbnail repository is called with flat ids array. This format is no longer supported with v6.5.0.0');
            }
            $mapped[] = $id;
        }

        return $this->innerRepo->delete($mapped, $context);
    }

    public function aggregate(Criteria $criteria, Context $context): AggregationResultCollection
    {
        return $this->innerRepo->aggregate($criteria, $context);
    }

    public function searchIds(Criteria $criteria, Context $context): IdSearchResult
    {
        return $this->innerRepo->searchIds($criteria, $context);
    }

    public function clone(string $id, Context $context, ?string $newId = null, ?CloneBehavior $behavior = null): EntityWrittenContainerEvent
    {
        return $this->innerRepo->clone($id, $context, $newId, $behavior);
    }

    public function search(Criteria $criteria, Context $context): EntitySearchResult
    {
        return $this->innerRepo->search($criteria, $context);
    }

    public function update(array $data, Context $context): EntityWrittenContainerEvent
    {
        return $this->innerRepo->update($data, $context);
    }

    public function upsert(array $data, Context $context): EntityWrittenContainerEvent
    {
        return $this->innerRepo->upsert($data, $context);
    }

    public function create(array $data, Context $context): EntityWrittenContainerEvent
    {
        return $this->innerRepo->create($data, $context);
    }

    public function createVersion(string $id, Context $context, ?string $name = null, ?string $versionId = null): string
    {
        return $this->innerRepo->createVersion($id, $context, $name, $versionId);
    }

    public function merge(string $versionId, Context $context): void
    {
        $this->innerRepo->merge($versionId, $context);
    }

    public function getDefinition(): EntityDefinition
    {
        return $this->innerRepo->getDefinition();
    }
}
