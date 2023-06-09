<?php declare(strict_types=1);

namespace Shopware\Storefront\Pagelet\Menu\Offcanvas;

use Shopware\Core\Framework\Log\Package;
use Shopware\Core\System\Annotation\Concept\ExtensionPattern\Decoratable;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Decoratable()
 */
#[Package('storefront')]
interface MenuOffcanvasPageletLoaderInterface
{
    public function load(Request $request, SalesChannelContext $context): MenuOffcanvasPagelet;
}
