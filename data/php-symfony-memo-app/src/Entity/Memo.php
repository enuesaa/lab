<?php

namespace App\Entity;

use App\Repository\MemoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\DatePointType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Clock\DatePoint;

#[ORM\Entity(repositoryClass: MemoRepository::class)]
class Memo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\WordCount(max: 500)]
    private ?string $description = null;

    #[ORM\Column(type: DatePointType::NAME)]
    private DatePoint $createdAt;

    #[ORM\Column(type: DatePointType::NAME)]
    private DatePoint $updatedAt;

    #[ORM\PrePersist]
    public function onCreate(): void {
        $this->createdAt = $this->updatedAt = new DatePoint();
    }

    #[ORM\PreUpdate]
    public function onUpdate(): void {
        $this->updatedAt = new DatePoint();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): DatePoint
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DatePoint $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DatePoint
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DatePoint $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
