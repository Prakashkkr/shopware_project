<?php declare(strict_types=1);

namespace SwagBundleElement\Core\Content\BundleElement\Aggregate\BundleElementTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBundleElement\Core\Content\BundleElement\BundleElementDefinition;

class BundleElementTranslationDefinition extends EntityTranslationDefinition
{
    public const ENTITY_NAME = 'bundle_element_translation';

    public function getEntityName(): string
    {

        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return BundleElementTranslationEntity::class;
    }

    public function getCollectionClass(): string
    {
        return BundleElementTranslationCollection::class;
    }

    public function getParentDefinitionClass(): string
    {
        return BundleElementDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('position', 'position'))->addFlags(new Required()),
        ]);
    }
}
