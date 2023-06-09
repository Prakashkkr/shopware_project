<?php declare(strict_types=1);

namespace Shopware\Storefront\Framework\Cache\ReverseProxy;

use Shopware\Core\Framework\Log\Package;
use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;

#[Package('storefront')]
class ReverseProxyCacheClearer implements CacheClearerInterface
{
    protected AbstractReverseProxyGateway $gateway;

    /**
     * @internal
     */
    public function __construct(AbstractReverseProxyGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function clear(string $cacheDir): void
    {
        $this->gateway->banAll();
    }
}
