<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class MemoRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 3, minMessage: '3文字以上で入力してください')]
        public readonly string $title = '',

        #[Assert\Length(max: 1000, maxMessage: '1000文字以内で入力してください')]
        public readonly string $description = '',
    ) {
    }
}
