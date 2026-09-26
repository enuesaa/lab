<?php

namespace App\Dto;

use App\Entity\Memo;

final readonly class MemoResponse
{
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public \DateTimeImmutable $createdAt,
        public \DateTimeImmutable $updatedAt,
    ) {
    }

    public static function fromEntity(Memo $memo): self
    {
        return new self(
            $memo->getId(),
            $memo->getTitle(),
            $memo->getDescription(),
            $memo->getCreatedAt(),
            $memo->getUpdatedAt(),
        );
    }
}
