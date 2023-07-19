<?php

declare(strict_types=1);

namespace Coservas\UuidConverter\Exception;

final class InvalidUuidException extends \Exception
{
    public function __construct(string $uuid)
    {
        parent::__construct('Invalid UUID = ' . $uuid);
    }
}