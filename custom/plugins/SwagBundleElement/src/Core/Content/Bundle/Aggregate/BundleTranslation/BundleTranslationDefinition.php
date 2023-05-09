<?php declare(strict_types=1);

namespace SwagBundleElement\Core\Content\Bundle\Aggregate\BundleTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBundleElement\Core\Content\Bundle\BundleDefinition;

class BundleTranslationDefinition extends EntityTranslationDefinition
{
    public const ENTITY_NAME = 'bundle_translation';

    public function getEntityName(): string
    {

        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return BundleTranslationEntity::class;
    }

    public function getCollectionClass(): string
    {
        return BundleTranslationCollection::class;
    }

    public function getParentDefinitionClass(): string
    {
        return BundleDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('name', 'name'))->addFlags(new Required()),
            (new StringField('description', 'description'))->addFlags(new Required()),
            (new StringField('headline', 'headline'))->addFlags(new Required()),
            (new StringField('position', 'position'))->addFlags(new Required()),
        ]);
    }
}
