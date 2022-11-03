<?php

namespace App\Entity;

use App\Repository\TangoSongRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TangoSongRepository::class)]
class Song
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $artist = null;

    #[ORM\Column(length: 5000)]
    private ?string $lyrics_spanish = null;

    #[ORM\Column(length: 5000, nullable: true)]
    private ?string $lyrics_english = null;

    #[ORM\Column(length: 5000, nullable: true)]
    private ?string $lyrics_french = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getArtist(): ?string
    {
        return $this->artist;
    }

    public function setArtist(?string $artist): self
    {
        $this->artist = $artist;

        return $this;
    }

    public function getLyricsSpanish(): ?string
    {
        return $this->lyrics_spanish;
    }

    public function setLyricsSpanish(string $lyrics_spanish): self
    {
        $this->lyrics_spanish = $lyrics_spanish;

        return $this;
    }

    public function getLyricsEnglish(): ?string
    {
        return $this->lyrics_english;
    }

    public function setLyricsEnglish(?string $lyrics_english): self
    {
        $this->lyrics_english = $lyrics_english;

        return $this;
    }

    public function getLyricsFrench(): ?string
    {
        return $this->lyrics_french;
    }

    public function setLyricsFrench(?string $lyrics_french): self
    {
        $this->lyrics_french = $lyrics_french;

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
