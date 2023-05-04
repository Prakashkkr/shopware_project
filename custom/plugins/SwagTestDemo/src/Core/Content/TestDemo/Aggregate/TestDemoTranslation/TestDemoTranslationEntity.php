<?php declare(strict_types=1);

namespace SwagTestDemo\Core\Content\TestDemo\Aggregate\TestDemoTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use SwagTestDemo\Core\Content\TestDemo\TestDemoEntity;
use Shopware\Core\System\Language\LanguageEntity;

class TestDemoTranslationEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $city;

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
    protected $testDemoId;

    /**
     * @var string
     */
    protected $languageId;

    /**
     * @var TestDemoEntity|null
     */
    protected $testDemo;

    /**
     * @var LanguageEntity|null
     */
    protected $language;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
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

    public function getTestDemoId(): string
    {
        return $this->testDemoId;
    }

    public function setTestDemoId(string $testDemoId): void
    {
        $this->testDemoId = $testDemoId;
    }

    public function getLanguageId(): string
    {
        return $this->languageId;
    }

    public function setLanguageId(string $languageId): void
    {
        $this->languageId = $languageId;
    }

    public function getTestDemo(): ?TestDemoEntity
    {
        return $this->testDemo;
    }

    public function setTestDemo(?TestDemoEntity $testDemo): void
    {
        $this->testDemo = $testDemo;
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