<?php declare(strict_types=1);

namespace SwagBundleElement\Core\Content\Bundle;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\FkField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\ApiAware;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslatedField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\TranslationsAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBundleElement\Core\Content\Bundle\Aggregate\BundleTranslation\BundleTranslationDefinition;
use SwagBundleElement\Core\Content\BundleElement\BundleElementDefinition;

class BundleDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'bundle';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }
    public function getEntityClass(): string
    {
        return BundleEntity::class;
    }

    public function getCollectionClass(): string
    {
        return BundleCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new PrimaryKey(), new ApiAware(), new Required()),
            (new BoolField('active','active')),
            (new TranslatedField('name')),
            (new TranslatedField('description')),
            (new TranslatedField('headline')),
            (new TranslatedField('position')),
            new FkField('bundle_element_id','bundleElementId',BundleElementDefinition::class,'id'),

            new TranslationsAssociationField(
                BundleTranslationDefinition::class,
                'bundle_id'
            )
        ]);
    }
}
