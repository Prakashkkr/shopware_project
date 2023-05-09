<?php declare(strict_types=1);

namespace SwagBundleElement\Core\Content\BundleElement;

use Shopware\Core\Content\Product\ProductDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Inherited;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ManyToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\ReferenceVersionField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBundleElement\Core\Content\BundleElement\Aggregate\BundleElementTranslation\BundleElementTranslationDefinition;

class BundleElementDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'bundle_element';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return BundleElementEntity::class;
    }

    public function getCollectionClass(): string
    {
        return BundleElementCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new Required()),
            (new StringField('discount_type', 'discount_type'))->addFlags(new ApiAware(), new Required()),
            (new TranslatedField('position')),
            (new StringField('discount', 'discount'))->addFlags(new ApiAware()),
            (new StringField('quantity', 'quantity'))->addFlags(new ApiAware()),
            new FkField('product_id','productId',ProductDefinition::class),
            (new ReferenceVersionField(ProductDefinition::class))->addFlags(new ApiAware(), new Inherited()),
            // product
            new ManyToOneAssociationField(
                'productIds',
                'product_id',
                ProductDefinition::class,
                'id',
                false
            ),
            new TranslationsAssociationField(
                BundleElementTranslationDefinition::class,
                'bundle_element_id'
            )
            ]);
    }
}
