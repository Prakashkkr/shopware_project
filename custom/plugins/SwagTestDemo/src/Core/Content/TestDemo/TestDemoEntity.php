<?php declare(strict_types=1);

namespace SwagTestDemo\Core\Content\TestDemo;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use Shopware\Core\System\Country\CountryEntity;
use Shopware\Core\System\Country\Aggregate\CountryState\CountryStateEntity;
use Shopware\Core\Content\Media\MediaEntity;
use Shopware\Core\Content\Product\ProductEntity;
use SwagTestDemo\Core\Content\TestDemo\Aggregate\TestDemoTranslation\TestDemoTranslationDefinition;

class TestDemoEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var bool|null
     */
    protected $active;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string|null
     */
    protected $countryId;

    /**
     * @var string|null
     */
    protected $countryStateId;

    /**
     * @var string|null
     */
    protected $mediaId;

    /**
     * @var string|null
     */
    protected $productId;

    /**
     * @var CountryEntity|null
     */
    protected $country;

    /**
     * @var CountryStateEntity|null
     */
    protected $countryState;

    /**
     * @var MediaEntity|null
     */
    protected $swagMedia;

    /**
     * @var ProductEntity|null
     */
    protected $productIds;

    /**
     * @var TestDemoTranslationDefinition|null
     */
    protected $translations;

    /**
     * @var \DateTimeInterface
     */
    protected $createdAt;

    /**
     * @var \DateTimeInterface|null
     */
    protected $updatedAt;

    /**
     * @var array|null
     */
    protected $translated;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): void
    {
        $this->active = $active;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getCountryId(): ?string
    {
        return $this->countryId;
    }

    public function setCountryId(?string $countryId): void
    {
        $this->countryId = $countryId;
    }

    public function getCountryStateId(): ?string
    {
        return $this->countryStateId;
    }

    public function setCountryStateId(?string $countryStateId): void
    {
        $this->countryStateId = $countryStateId;
    }

    public function getMediaId(): ?string
    {
        return $this->mediaId;
    }

    public function setMediaId(?string $mediaId): void
    {
        $this->mediaId = $mediaId;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function setProductId(?string $productId): void
    {
        $this->productId = $productId;
    }

    public function getCountry(): ?CountryEntity
    {
        return $this->country;
    }

    public function setCountry(?CountryEntity $country): void
    {
        $this->country = $country;
    }

    public function getCountryState(): ?CountryStateEntity
    {
        return $this->countryState;
    }

    public function setCountryState(?CountryStateEntity $countryState): void
    {
        $this->countryState = $countryState;
    }

    public function getSwagMedia(): ?MediaEntity
    {
        return $this->swagMedia;
    }

    public function setSwagMedia(?MediaEntity $swagMedia): void
    {
        $this->swagMedia = $swagMedia;
    }

    public function getProductIds(): ?ProductEntity
    {
        return $this->productIds;
    }

    public function setProductIds(?ProductEntity $productIds): void
    {
        $this->productIds = $productIds;
    }

    public function getTranslations(): ?TestDemoTranslationDefinition
    {
        return $this->translations;
    }

    public function setTranslations(TestDemoTranslationDefinition $translations): void
    {
        $this->translations = $translations;
    }

    public function getCreatedAt(): \DateTimeInterface
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

    public function getTranslated(): array
    {
        return $this->translated;
    }

    public function setTranslated(?array $translated): void
    {
        $this->translated = $translated;
    }
}