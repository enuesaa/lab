<?php

namespace App\Dto;

final class EmptyResponse
{
    public static function create(): \stdClass
    {
        return new \stdClass();
    }
}
