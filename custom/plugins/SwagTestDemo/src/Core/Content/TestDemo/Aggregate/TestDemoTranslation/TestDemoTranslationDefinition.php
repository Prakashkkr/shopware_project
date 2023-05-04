<?php declare(strict_types=1);

namespace SwagTestDemo\Core\Content\TestDemo\Aggregate\TestDemoTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagTestDemo\Core\Content\TestDemo\TestDemoDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;

class TestDemoTranslationDefinition extends EntityTranslationDefinition
{
    public const ENTITY_NAME = 'test_demo_translation';

    public function getEntityName(): string
    {

        return self::ENTITY_NAME;
    }
    public function getEntityClass(): string
    {
        return TestDemoTranslationEntity::class;
    }

    public function getCollectionClass(): string
    {
        return TestDemoTranslationDefinition::class;
    }

    public function getParentDefinitionClass(): string
    {
        return TestDemoDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('name', 'name'))->addFlags(new Required()),
            (new StringField('city','city'))->addFlags(new Required())
        ]);
    }
}
