<?php
declare(strict_types=1);

namespace SwagTestDemo\Core\Content\Extension;

use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\Language\LanguageDefinition;
use SwagTestDemo\Core\Content\TestDemo\Aggregate\TestDemoTranslation\TestDemoTranslationDefinition;

class LanguageExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField(
                'SwagShipTransId',
                TestDemoTranslationDefinition::class,
                'swag_shop_id',
            'id')
        );
    }

    public function getDefinitionClass(): string
    {

        return LanguageDefinition::class;
    }
}

