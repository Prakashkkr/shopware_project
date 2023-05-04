<?php declare(strict_types=1);
namespace SwagBlogFinder\Core\Content\Extension;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBlogFinder\Core\Content\BlogFinder\BlogFinderDefinition;
use SwagBlogFinder\Core\Content\Mapping\BlogFinderMappingDefinition;

class ProductExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new ManyToManyAssociationField(
                'BlogFinderId',
                BlogFinderDefinition::class,
                BlogFinderMappingDefinition::class,
                'product_id',
                'blog_finder_id',
                'id',
                'id'
            ),
        );
    }

    public function getDefinitionClass(): string
    {
        return ProductDefinition::class;
    }
}

