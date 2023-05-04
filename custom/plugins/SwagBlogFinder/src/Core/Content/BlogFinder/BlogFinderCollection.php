<?php declare(strict_types=1);

namespace SwagBlogFinder\Core\Content\BlogFinder;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void                add(BlogFinderEntity $entity)
 * @method void                set(string $key, BlogFinderEntity $entity)
 * @method BlogFinderEntity[]    getIterator()
 * @method BlogFinderEntity[]    getElements()
 * @method BlogFinderEntity|null get(string $key)
 * @method BlogFinderEntity|null first()
 * @method BlogFinderEntity|null last()
 */
 #[Package('core')]
class BlogFinderCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return BlogFinderEntity::class;
    }
}