<?php declare(strict_types=1);

namespace Shopware\Docs\Convert;

use Shopware\Core\Framework\Log\Package;
use Symfony\Component\Finder\SplFileInfo;

#[Package('core')]
class PlatformUpdatesDocument extends Document
{
    /**
     * @var \DateTimeInterface
     */
    private $date;

    public function __construct(\DateTimeInterface $date, SplFileInfo $file, bool $isCategory, string $baseUrl)
    {
        parent::__construct($file, $isCategory, $baseUrl);

        $this->date = $date;
    }

    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }
}
