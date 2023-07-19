<?php

declare(strict_types=1);

namespace Coservas\UuidConverter\Exception;

final class InvalidPartsException extends \Exception
{
    public function __construct(int ...$parts)
    {
        parent::__construct('Invalid parts = ' . implode(', ', $parts));
    }
}