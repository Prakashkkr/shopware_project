<?php declare(strict_types=1);

namespace SwagBlogFinder\Core\Content\BlogFinder\Aggregate\BlogFinderTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void                add(BlogFinderTranslationEntity $entity)
 * @method void                set(string $key, BlogFinderTranslationEntity $entity)
 * @method BlogFinderTranslationEntity[]    getIterator()
 * @method BlogFinderTranslationEntity[]    getElements()
 * @method BlogFinderTranslationEntity|null get(string $key)
 * @method BlogFinderTranslationEntity|null first()
 * @method BlogFinderTranslationEntity|null last()
 */
 #[Package('core')]
class BlogFinderTranslationCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return BlogFinderTranslationEntity::class;
    }
}