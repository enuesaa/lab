<?php

namespace App\Dto;

use App\Entity\Memo;

final class MemoResponse
{
    public static function fromEntity(Memo $memo): array
    {
        return [
            'id' => $memo->getId(),
            'title' => $memo->getTitle(),
            'description' => $memo->getDescription(),
            'createdAt' => $memo->getCreatedAt()?->format(\DATE_ATOM),
            'updatedAt' => $memo->getUpdatedAt()?->format(\DATE_ATOM),
        ];
    }
}
