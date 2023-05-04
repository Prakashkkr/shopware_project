<?php declare(strict_types=1);

namespace SwagTestDemo\Core\Content\TestDemo\Aggregate\TestDemoTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;
use Shopware\Core\Framework\Log\Package;

/**
 * @method void                add(TestDemoTranslationEntity $entity)
 * @method void                set(string $key, TestDemoTranslationEntity $entity)
 * @method TestDemoTranslationEntity[]    getIterator()
 * @method TestDemoTranslationEntity[]    getElements()
 * @method TestDemoTranslationEntity|null get(string $key)
 * @method TestDemoTranslationEntity|null first()
 * @method TestDemoTranslationEntity|null last()
 */
 #[Package('core')]
class TestDemoTranslationCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return TestDemoTranslationEntity::class;
    }
}