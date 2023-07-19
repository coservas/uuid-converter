<?php

declare(strict_types=1);

namespace Coservas\UuidConverter;

final class ConverterType
{
    public const SIGNED_64_BIT_BIG_ENDIAN = 1;
    public const UNSIGNED_32_BIT_BIG_ENDIAN = 2;

    public const TYPES = [
        self::SIGNED_64_BIT_BIG_ENDIAN,
        self::UNSIGNED_32_BIT_BIG_ENDIAN,
    ];
}