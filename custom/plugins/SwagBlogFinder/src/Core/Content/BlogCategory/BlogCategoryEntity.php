<?php declare(strict_types=1);

namespace SwagBlogFinder\Core\Content\BlogCategory;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use SwagBlogFinder\Core\Content\BlogFinder\BlogFinderCollection;
use SwagBlogFinder\Core\Content\BlogCategory\Aggregate\BlogCategoryTranslation\BlogCategoryTranslationCollection;

class BlogCategoryEntity extends Entity
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
     * @var BlogFinderCollection|null
     */
    protected $blogFinderIds;

    /**
     * @var BlogCategoryTranslationCollection|null
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

    public function getBlogFinderIds(): ?BlogFinderCollection
    {
        return $this->blogFinderIds;
    }

    public function setBlogFinderIds(BlogFinderCollection $blogFinderIds): void
    {
        $this->blogFinderIds = $blogFinderIds;
    }

    public function getTranslations(): ?BlogCategoryTranslationCollection
    {
        return $this->translations;
    }

    public function setTranslations(BlogCategoryTranslationCollection $translations): void
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
