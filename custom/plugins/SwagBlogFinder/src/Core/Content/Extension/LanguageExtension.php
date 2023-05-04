<?php
declare(strict_types=1);

namespace SwagBlogFinder\Core\Content\Extension;

use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\Language\LanguageDefinition;
use SwagBlogFinder\Core\Content\BlogCategory\Aggregate\BlogCategoryTranslation\BlogCategoryTranslationDefinition;
use SwagBlogFinder\Core\Content\BlogFinder\Aggregate\BlogFinderTranslation\BlogFinderTranslationDefinition;

class LanguageExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField(
                'BlogFinderTranslationId',
                BlogFinderTranslationDefinition::class,
                'blog_finder_translation_id',
                'id')
        );
        $collection->add(
            new OneToManyAssociationField(
                'BlogCategoryTranslationId',
                BlogCategoryTranslationDefinition::class,
                'blog_category_translation_id',
                'id')
        );

    }
    public function getDefinitionClass(): string
    {

        return LanguageDefinition::class;
    }
}

