<?php declare(strict_types=1);

namespace Shopware\Core\System\SalesChannel\Entity;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityLoadedEvent;
use Shopware\Core\Framework\Event\ShopwareSalesChannelEvent;
use Shopware\Core\Framework\Feature;
use Shopware\Core\Framework\Log\Package;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

#[Package('sales-channel')]
class SalesChannelEntityLoadedEvent extends EntityLoadedEvent implements ShopwareSalesChannelEvent
{
    /**
     * @var SalesChannelContext
     */
    private $salesChannelContext;

    public function __construct(EntityDefinition $definition, array $entities, SalesChannelContext $context, bool $nested = true)
    {
        parent::__construct($definition, $entities, $context->getContext(), $nested);
        $this->salesChannelContext = $context;
    }

    public function getName(): string
    {
        return 'sales_channel.' . parent::getName();
    }

    public function getSalesChannelContext(): SalesChannelContext
    {
        return $this->salesChannelContext;
    }

    /**
     * @deprecated tag:v6.5.0 (flag:FEATURE_NEXT_16155) - remove all code below in this function. Nested loaded events are generated over EntityLoadedEventFactory
     */
    protected function createNested(EntityDefinition $definition, array $entities): EntityLoadedEvent
    {
        Feature::triggerDeprecationOrThrow(
            'v6.5.0.0',
            Feature::deprecatedMethodMessage(__CLASS__, __METHOD__, 'v6.5.0.0', 'EntityLoadedEventFactory')
        );

        return new self($definition, $entities, $this->salesChannelContext, false);
    }
}
