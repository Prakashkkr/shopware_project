<?php declare(strict_types=1);

namespace SwagBundleElement\Core\Content\BundleElement;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use Shopware\Core\Content\Product\ProductEntity;
use SwagBundleElement\Core\Content\BundleElement\Aggregate\BundleElementTranslation\BundleElementTranslationCollection;

class BundleElementEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $discount_type;

    /**
     * @var string
     */
    protected $position;

    /**
     * @var string|null
     */
    protected $discount;

    /**
     * @var string|null
     */
    protected $quantity;

    /**
     * @var string|null
     */
    protected $productId;

    /**
     * @var ProductEntity|null
     */
    protected $productIds;

    /**
     * @var BundleElementTranslationCollection|null
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

    public function getDiscount_type(): string
    {
        return $this->discount_type;
    }

    public function setDiscount_type(string $discount_type): void
    {
        $this->discount_type = $discount_type;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(?string $discount): void
    {
        $this->discount = $discount;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(?string $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function setProductId(?string $productId): void
    {
        $this->productId = $productId;
    }

    public function getProductIds(): ?ProductEntity
    {
        return $this->productIds;
    }

    public function setProductIds(?ProductEntity $productIds): void
    {
        $this->productIds = $productIds;
    }

    public function getTranslations(): ?BundleElementTranslationCollection
    {
        return $this->translations;
    }

    public function setTranslations(BundleElementTranslationCollection $translations): void
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