<?php

namespace App\Repository;

use App\Entity\Memo;

final class MemoPage
{
    /**
     * @param Memo[] $memos
     */
    public function __construct(
        public readonly array $memos,
        public readonly ?string $nextCursor,
    ) {
    }
}
