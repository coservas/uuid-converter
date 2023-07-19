<?php

declare(strict_types=1);

namespace Coservas\UuidConverter\Scheme;

interface SchemeInterface
{
    /**
     * @return non-empty-string
     */
    public function getStringUuid(): string;

    /**
     * @return int[]
     */
    public function getIntParts(): array;
}