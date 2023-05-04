<?php declare(strict_types=1);

namespace SwagBlogFinder\Core\Content\BlogFinder\Aggregate\BlogFinderTranslation;

use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;
use SwagBlogFinder\Core\Content\BlogFinder\BlogFinderEntity;
use Shopware\Core\System\Language\LanguageEntity;

class BlogFinderTranslationEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

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
    protected $blogFinderId;

    /**
     * @var string
     */
    protected $languageId;

    /**
     * @var BlogFinderEntity|null
     */
    protected $blogFinder;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
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

    public function getBlogFinderId(): string
    {
        return $this->blogFinderId;
    }

    public function setBlogFinderId(string $blogFinderId): void
    {
        $this->blogFinderId = $blogFinderId;
    }

    public function getLanguageId(): string
    {
        return $this->languageId;
    }

    public function setLanguageId(string $languageId): void
    {
        $this->languageId = $languageId;
    }

    public function getBlogFinder(): ?BlogFinderEntity
    {
        return $this->blogFinder;
    }

    public function setBlogFinder(?BlogFinderEntity $blogFinder): void
    {
        $this->blogFinder = $blogFinder;
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
