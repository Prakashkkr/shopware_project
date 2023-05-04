<?php declare(strict_types=1);

namespace SwagBlogFinder\Core\Content\BlogCategory;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBlogFinder\Core\Content\BlogCategory\Aggregate\BlogCategoryTranslation\BlogCategoryTranslationDefinition;
use SwagBlogFinder\Core\Content\BlogFinder\BlogFinderDefinition;


class BlogCategoryDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'blog_category';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }
    public function getEntityClass(): string
    {
        return BlogCategoryEntity::class;
    }
    public function getCollectionClass(): string
    {
        return BlogCategoryCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
                (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
                (new TranslatedField('name')),

                //category
                new OneToManyAssociationField(
                    'blogFinderIds',
                    BlogFinderDefinition::class,
                    'blog_category_id'),
                //Translation
                new TranslationsAssociationField(
                    BlogCategoryTranslationDefinition::class,
                    'blog_category_id'
                )
            ]);
    }
}
