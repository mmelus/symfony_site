<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContentRepository::class)]
#[ORM\UniqueConstraint(
    name: 'content_unique_idx',
    columns: ['content_code', 'language']
  )]
class Content
{
    const BUGS = "BUGS";
    const SERVICES = "SERVICES";  
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content_category = null;

    #[ORM\Column(length: 5)]
    private int $content_order;
    
    #[ORM\Column(length: 255)]
    private ?string $content_code = null;

    #[ORM\Column(length: 2)]
    private ?string $language = null;

    #[ORM\Column(length: 750)]
    private ?string $title = null;

    #[ORM\Column(length: 5000)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getContentOrder(): ?int
    {
        return $this->content_order;
    }
    public function setContentOrder(int $content_order): self
    {
        $this->content_order = $content_order;
        return $this;
    }

    public function getContentCode(): ?string
    {
        return $this->content_code;
    }

    public function setContentCode(string $content_code): self
    {
        $this->content_code = $content_code;

        return $this;
    }

    public function getContentCategory(): ?string
    {
        return $this->content_category;
    }

    public function setContentCategory(string $content_category): self
    {
        $this->content_category = $content_category;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
