<?php
declare(strict_types=1);

namespace SwagBundleElement\Core\Content\Extension;

use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\Language\LanguageDefinition;
use SwagBundleElement\Core\Content\Bundle\Aggregate\BundleTranslation\BundleTranslationDefinition;
use SwagBundleElement\Core\Content\BundleElement\Aggregate\BundleElementTranslation\BundleElementTranslationDefinition;

class LanguageExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField(
                'BundleElementTranslationId',
                BundleElementTranslationDefinition::class,
                'bundle_element_id',
            'id')
        );

        $collection->add(
            new OneToManyAssociationField(
                'BundleTranslationId',
                BundleTranslationDefinition::class,
                'bundle_id',
                'id')
        );
    }

    public function getDefinitionClass(): string
    {

        return LanguageDefinition::class;
    }
}

