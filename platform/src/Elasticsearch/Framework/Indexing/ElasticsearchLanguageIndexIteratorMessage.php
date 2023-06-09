<?php declare(strict_types=1);

namespace Shopware\Elasticsearch\Framework\Indexing;

use Shopware\Core\Framework\Log\Package;

/**
 * @internal
 */
#[Package('core')]
class ElasticsearchLanguageIndexIteratorMessage
{
    private string $languageId;

    /**
     * @internal
     */
    public function __construct(string $languageId)
    {
        $this->languageId = $languageId;
    }

    public function getLanguageId(): string
    {
        return $this->languageId;
    }
}
