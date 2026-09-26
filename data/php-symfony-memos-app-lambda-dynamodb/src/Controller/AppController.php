<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class AppController extends AbstractController
{
    protected function json(mixed $data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        $context = array_merge([
            'preserve_empty_objects' => true, // stdClass を {} へ
        ], $context);

        return parent::json($data, $status, $headers, $context);
    }
}
