<?php

namespace App\Response;

use App\Entity\Memo;

final class MemoResponse
{
    public static function fromEntity(Memo $memo): array
    {
        return [
            'id' => $memo->getId(),
            'title' => $memo->getTitle(),
            'description' => $memo->getDescription(),
            'created_at' => $memo->getCreatedAt()?->format(\DATE_ATOM),
            'updated_at' => $memo->getUpdatedAt()?->format(\DATE_ATOM),
        ];
    }

    public static function deleted(): object
    {
        return (object)[];
    }
}
