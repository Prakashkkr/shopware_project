<?php declare(strict_types=1);

namespace SwagBlogFinder\Core\Content\BlogFinder;


use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\DateTimeField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBlogFinder\Core\Content\BlogCategory\BlogCategoryDefinition;
use SwagBlogFinder\Core\Content\BlogFinder\Aggregate\BlogFinderTranslation\BlogFinderTranslationDefinition;
use SwagBlogFinder\Core\Content\Mapping\BlogFinderMappingDefinition;


class BlogFinderDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'blog_finder';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }
    public function getEntityClass(): string
    {
        return BlogFinderEntity::class;
    }
    public function getCollectionClass(): string
    {
        return BlogFinderCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
                (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new ApiAware(), new Required()),
                (new TranslatedField('name')),
                (new TranslatedField('description')),
                (new DateTimeField('release_date','release_date')),
                (new BoolField('active','active')),
                 new FkField('blog_category_id','blogCategoryId',BlogCategoryDefinition::class,'id'),

            (new StringField('Author','Author')),
                //product association
                new ManyToManyAssociationField(
                    'products',
                    ProductDefinition::class,
                    BlogFinderMappingDefinition::class,
                    'blog_finder_id',
                    'product_id',
                    'id',
                    'id'
                ),
                //category
                new ManyToOneAssociationField(
                    'blogCategory',
                    'blog_category_id',
                    blogCategoryDefinition::class,
                    'id',
                    false
                ),

                //Translation
                new TranslationsAssociationField(
                    BlogFinderTranslationDefinition::class,
                    'blog_finder_id'
                )
            ]);
    }
}
