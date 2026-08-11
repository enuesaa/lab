<?php

namespace App\Entity;

use App\Repository\MemoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\DatePointType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Clock\DatePoint;

#[ORM\Table(name: 'memos')]
#[ORM\Entity(repositoryClass: MemoRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Memo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: DatePointType::NAME)]
    private DatePoint $created_at;

    #[ORM\Column(type: DatePointType::NAME)]
    private DatePoint $updated_at;

    #[ORM\PrePersist]
    public function onCreate(): void {
        $this->created_at = $this->updated_at = new DatePoint();
    }

    #[ORM\PreUpdate]
    public function onUpdate(): void {
        $this->updated_at = new DatePoint();
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
        return $this->created_at;
    }

    public function setCreatedAt(DatePoint $createdAt): static
    {
        $this->created_at = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DatePoint
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(DatePoint $updatedAt): static
    {
        $this->updated_at = $updatedAt;

        return $this;
    }
}
