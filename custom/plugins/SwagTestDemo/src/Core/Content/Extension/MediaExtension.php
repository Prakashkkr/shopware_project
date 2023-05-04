<?php declare(strict_types=1);
namespace SwagTestDemo\Core\Content\Extension;

use Shopware\Core\Framework\DataAbstractionLayer\EntityExtension;
use Shopware\Core\Framework\DataAbstractionLayer\Field\OneToOneAssociationField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Content\Media\MediaDefinition;
use SwagTestDemo\Core\Content\TestDemo\TestDemoDefinition;


class MediaExtension extends EntityExtension
{
    public function extendFields(FieldCollection $collection): void
    {
        $collection->add(
            new OneToOneAssociationField(
                 'SwagTestDemoMedia',
                'id',
                'media_id',
                    TestDemoDefinition::class,
                    false)
        );
    }

    public function getDefinitionClass(): string
    {

        return MediaDefinition::class;
    }
}


