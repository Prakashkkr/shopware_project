<?php declare(strict_types=1);

namespace SwagTestDemo\Core\Content\TestDemo;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;
use Shopware\Core\Framework\Log\Package;

/**
 * @method void                add(TestDemoEntity $entity)
 * @method void                set(string $key, TestDemoEntity $entity)
 * @method TestDemoEntity[]    getIterator()
 * @method TestDemoEntity[]    getElements()
 * @method TestDemoEntity|null get(string $key)
 * @method TestDemoEntity|null first()
 * @method TestDemoEntity|null last()
 */
 #[Package('core')]
class TestDemoCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return TestDemoEntity::class;
    }
}