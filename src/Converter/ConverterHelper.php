<?php

declare(strict_types=1);

namespace Coservas\UuidConverter\Converter;

class ConverterHelper
{
    public const UUID_REGEX_PATTERN = '/^([\da-f]{8})([\da-f]{4})([\da-f]{4})([\da-f]{4})([\da-f]{12})$/';

    public static function uuidToParts(string $format, string $uuid): array
    {
        $parts = unpack($format, self::uuidToBinary($uuid));

        return $parts === false ? [] : $parts;
    }

    public static function partsToUuid(string $packFormat, int ...$parts): string
    {
        $hex = self::binaryToHex(
            self::partsToBinary($packFormat, ...$parts)
        );

        $matches = [];
        return preg_match(self::UUID_REGEX_PATTERN, $hex, $matches) > 0
            ? "{$matches[1]}-{$matches[2]}-{$matches[3]}-{$matches[4]}-{$matches[5]}"
            : '';
    }

    private static function uuidToBinary(string $uuid): string
    {
        return pack("H*", self::uuidToHex($uuid)) ?: '';
    }

    private static function uuidToHex(string $uuid): string
    {
        return str_replace('-', '', $uuid);
    }

    private static function binaryToHex(string $binary): string
    {
        $hex = unpack('H*', $binary);

        return $hex !== false ? ($hex[1] ?? '') : '';
    }

    private static function partsToBinary(string $packFormat, int ...$parts): string
    {
        return pack($packFormat, ...$parts);
    }
}