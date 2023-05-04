<?php declare(strict_types=1);

namespace SwagBlogFinder\Core\Content\BlogFinder\Aggregate\BlogFinderTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\EntityTranslationDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use SwagBlogFinder\Core\Content\BlogFinder\BlogFinderDefinition;

class BlogFinderTranslationDefinition extends EntityTranslationDefinition
{
    public const ENTITY_NAME = 'blog_finder_translation';

    public function getEntityName(): string
    {

        return self::ENTITY_NAME;
    }
    public function getEntityClass(): string
    {
        return BlogFinderTranslationEntity::class;
    }
    public function getCollectionClass(): string
    {
        return BlogFinderTranslationCollection::class;
    }

    public function getParentDefinitionClass(): string
    {
        return BlogFinderDefinition::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new StringField('name', 'name'))->addFlags(new Required()),
            (new StringField('description', 'description'))->addFlags(new Required()),
        ]);
    }
}
