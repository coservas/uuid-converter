<?php

declare(strict_types=1);

namespace Coservas\UuidConverter;

use Coservas\UuidConverter\Converter\Signed64BitBigEndianConverter;
use Coservas\UuidConverter\Converter\Unsigned32BitBigEndianConverter;
use Coservas\UuidConverter\Exception\ConverterNotFoundException;
use Coservas\UuidConverter\Exception\InvalidPartsException;
use Coservas\UuidConverter\Exception\InvalidUuidException;
use Coservas\UuidConverter\Scheme\SchemeInterface;

class UuidConverter
{
    /**
     * @param value-of<ConverterType::TYPES> $type
     * @param non-empty-string $uuid
     *
     * @throws InvalidUuidException
     * @throws ConverterNotFoundException
     */
    public static function fromUuid(int $type, string $uuid): SchemeInterface
    {
        return match ($type) {
            ConverterType::SIGNED_64_BIT_BIG_ENDIAN => Signed64BitBigEndianConverter::fromUuid($uuid),
            ConverterType::UNSIGNED_32_BIT_BIG_ENDIAN => Unsigned32BitBigEndianConverter::fromUuid($uuid),
            default => throw new ConverterNotFoundException($type),
        };
    }

    /**
     * @param value-of<ConverterType::TYPES> $type
     *
     * @throws InvalidPartsException
     * @throws ConverterNotFoundException
     */
    public static function fromParts(int $type, int ...$parts): SchemeInterface
    {
        return match ($type) {
            ConverterType::SIGNED_64_BIT_BIG_ENDIAN => Signed64BitBigEndianConverter::fromParts(...$parts),
            ConverterType::UNSIGNED_32_BIT_BIG_ENDIAN => Unsigned32BitBigEndianConverter::fromParts(...$parts),
            default => throw new ConverterNotFoundException($type),
        };
    }
}