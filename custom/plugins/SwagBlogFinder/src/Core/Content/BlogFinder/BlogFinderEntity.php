<?php declare(strict_types=1);

namespace SwagBlogFinder\Core\Content\BlogFinder;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use Shopware\Core\Content\Product\ProductCollection;
use SwagBlogFinder\Core\Content\BlogCategory\BlogCategoryEntity;
use SwagBlogFinder\Core\Content\BlogFinder\Aggregate\BlogFinderTranslation\BlogFinderTranslationCollection;

class BlogFinderEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var \DateTimeInterface|null
     */
    protected $release_date;

    /**
     * @var bool|null
     */
    protected $active;

    /**
     * @var string|null
     */
    protected $blogCategoryId;

    /**
     * @var string|null
     */
    protected $Author;

    /**
     * @var ProductCollection|null
     */
    protected $products;

    /**
     * @var BlogCategoryEntity|null
     */
    protected $blogCategory;

    /**
     * @var BlogFinderTranslationCollection|null
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getRelease_date(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setRelease_date(?\DateTimeInterface $release_date): void
    {
        $this->release_date = $release_date;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): void
    {
        $this->active = $active;
    }

    public function getBlogCategoryId(): ?string
    {
        return $this->blogCategoryId;
    }

    public function setBlogCategoryId(?string $blogCategoryId): void
    {
        $this->blogCategoryId = $blogCategoryId;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    public function getProducts(): ?ProductCollection
    {
        return $this->products;
    }

    public function setProducts(ProductCollection $products): void
    {
        $this->products = $products;
    }

    public function getBlogCategory(): ?BlogCategoryEntity
    {
        return $this->blogCategory;
    }

    public function setBlogCategory(?BlogCategoryEntity $blogCategory): void
    {
        $this->blogCategory = $blogCategory;
    }

    public function getTranslations(): ?BlogFinderTranslationCollection
    {
        return $this->translations;
    }

    public function setTranslations(BlogFinderTranslationCollection $translations): void
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
