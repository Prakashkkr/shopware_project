<?php declare(strict_types=1);

namespace SwagBundleElement\Core\Content\BundleElement;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void                add(BundleElementEntity $entity)
 * @method void                set(string $key, BundleElementEntity $entity)
 * @method BundleElementEntity[]    getIterator()
 * @method BundleElementEntity[]    getElements()
 * @method BundleElementEntity|null get(string $key)
 * @method BundleElementEntity|null first()
 * @method BundleElementEntity|null last()
 */
 #[Package('core')]
class BundleElementCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return BundleElementEntity::class;
    }
}