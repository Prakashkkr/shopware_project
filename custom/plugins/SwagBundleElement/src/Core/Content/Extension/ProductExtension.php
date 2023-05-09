<?php declare(strict_types=1);
namespace SwagBundleElement\Core\Content\Extension;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBundleElement\Core\Content\BundleElement\BundleElementDefinition;

class ProductExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField(
                'productIds',
                BundleElementDefinition::class,
                'product_id',
                 'id')
        );
    }

    public function getDefinitionClass(): string
    {

        return ProductDefinition::class;
    }
}

