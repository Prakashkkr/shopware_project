<?php declare(strict_types=1);

namespace SwagBundleElement\Core\Content\BundleElement\Aggregate\BundleElementTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use SwagBundleElement\Core\Content\BundleElement\BundleElementEntity;
use Shopware\Core\System\Language\LanguageEntity;

class BundleElementTranslationEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $position;

    /**
     * @var \DateTimeInterface
     */
    protected $createdAt;

    /**
     * @var \DateTimeInterface|null
     */
    protected $updatedAt;

    /**
     * @var string
     */
    protected $bundleElementId;

    /**
     * @var string
     */
    protected $languageId;

    /**
     * @var BundleElementEntity|null
     */
    protected $bundleElement;

    /**
     * @var LanguageEntity|null
     */
    protected $language;

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getBundleElementId(): string
    {
        return $this->bundleElementId;
    }

    public function setBundleElementId(string $bundleElementId): void
    {
        $this->bundleElementId = $bundleElementId;
    }

    public function getLanguageId(): string
    {
        return $this->languageId;
    }

    public function setLanguageId(string $languageId): void
    {
        $this->languageId = $languageId;
    }

    public function getBundleElement(): ?BundleElementEntity
    {
        return $this->bundleElement;
    }

    public function setBundleElement(?BundleElementEntity $bundleElement): void
    {
        $this->bundleElement = $bundleElement;
    }

    public function getLanguage(): ?LanguageEntity
    {
        return $this->language;
    }

    public function setLanguage(?LanguageEntity $language): void
    {
        $this->language = $language;
    }
}
