<?php
declare(strict_types=1);

namespace SwagTestDemo\Core\Content\Extension;

use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToManyAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\System\Country\Aggregate\CountryState\CountryStateDefinition;
use SwagTestDemo\Core\Content\TestDemo\TestDemoDefinition;

class CountryStateExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToManyAssociationField(
                'countryStateId',
                TestDemoDefinition::class,
                'country_state_id'
            )
        );
    }

    public function getDefinitionClass(): string
    {
        return CountryStateDefinition::class;
    }
}

