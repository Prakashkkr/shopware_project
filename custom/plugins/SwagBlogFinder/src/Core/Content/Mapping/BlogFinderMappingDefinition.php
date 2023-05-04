<?php declare(strict_types=1);
namespace SwagBlogFinder\Core\Content\Mapping;


use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Inherited;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\MappingEntityDefinition;
use SwagBlogFinder\Core\Content\BlogFinder\BlogFinderDefinition;

class BlogFinderMappingDefinition extends MappingEntityDefinition
{
    public const ENTITY_NAME ='blog_finder_mapping';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }
    public function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new FkField('blog_finder_id', 'blogFinderId', BlogFinderDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            (new FkField('product_id', 'productId', ProductDefinition::class))->addFlags(new PrimaryKey(), new Required()),
            (new ReferenceVersionField(ProductDefinition::class))->addFlags(new ApiAware(), new Inherited()),

            new ManyToOneAssociationField(
                'product',
                'product_id',
                ProductDefinition::class,
                'id',
                false
            ),
            new ManyToOneAssociationField(
                'blogFinderIds',
                'blog_finder_id',
                BlogFinderDefinition::class,
                'id'
            )

            ]);

    }

}