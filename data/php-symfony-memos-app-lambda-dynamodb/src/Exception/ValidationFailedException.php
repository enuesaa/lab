<?php

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidationFailedException extends \RuntimeException
{
    public function __construct(
        private readonly ConstraintViolationListInterface $violations,
    ) {
        parent::__construct('Validation failed.');
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
