<?php

namespace App\Response;

use App\Entity\Memo;

final class MemoResponse implements \JsonSerializable
{
    private function __construct(
        private readonly ?string $id,
        private readonly ?string $title,
        private readonly ?string $description,
        private readonly ?string $createdAt,
        private readonly ?string $updatedAt,
    ) {
    }

    public static function fromEntity(Memo $memo): self
    {
        return new self(
            $memo->getId(),
            $memo->getTitle(),
            $memo->getDescription(),
            $memo->getCreatedAt()?->format(\DATE_ATOM),
            $memo->getUpdatedAt()?->format(\DATE_ATOM),
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
