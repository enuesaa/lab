<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

#[AsEventListener(event: 'kernel.exception')]
final class ApiExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $previous = $exception->getPrevious();

        $event->setResponse(match (true) {
            $previous instanceof ValidationFailedException => $this->validationResponse($exception, $previous),
            $exception instanceof HttpExceptionInterface => new JsonResponse(['error' => $exception->getMessage()], $exception->getStatusCode()),
            default => new JsonResponse(['error' => 'Internal Server Error'], 500),
        });
    }

    private function validationResponse(\Throwable $exception, ValidationFailedException $previous): JsonResponse
    {
        $errors = [];
        foreach ($previous->getViolations() as $violation) {
            $errors[$violation->getPropertyPath()][] = $violation->getMessage();
        }

        $status = $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 422;

        return new JsonResponse(['errors' => $errors], $status);
    }
}
