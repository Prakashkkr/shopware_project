<?php declare(strict_types=1);

namespace SwagBundleElement\Core\Content\BundleElement\Aggregate\BundleElementTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void                add(BundleElementTranslationEntity $entity)
 * @method void                set(string $key, BundleElementTranslationEntity $entity)
 * @method BundleElementTranslationEntity[]    getIterator()
 * @method BundleElementTranslationEntity[]    getElements()
 * @method BundleElementTranslationEntity|null get(string $key)
 * @method BundleElementTranslationEntity|null first()
 * @method BundleElementTranslationEntity|null last()
 */
 #[Package('core')]
class BundleElementTranslationCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return BundleElementTranslationEntity::class;
    }
}