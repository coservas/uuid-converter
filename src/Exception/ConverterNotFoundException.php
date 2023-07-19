<?php

declare(strict_types=1);

namespace Coservas\UuidConverter\Exception;

final class ConverterNotFoundException extends \Exception
{
    public function __construct(int $type)
    {
        parent::__construct('Converter not found = ' . $type);
    }
}