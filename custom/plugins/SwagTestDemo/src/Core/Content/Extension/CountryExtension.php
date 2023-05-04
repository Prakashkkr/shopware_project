<?php declare(strict_types=1);

namespace SwagTestDemo\Core\Content\Extension;

use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\Country\CountryDefinition;
use SwagTestDemo\Core\Content\TestDemo\TestDemoDefinition;

class CountryExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField(
                'countryId',
                TestDemoDefinition::class,
                'country_id',
            'id')
        );
    }

    public function getDefinitionClass(): string
    {

        return CountryDefinition::class;
    }
}

