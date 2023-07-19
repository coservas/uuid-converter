<?php

declare(strict_types=1);

namespace Coservas\UuidConverter\Converter;

use Coservas\UuidConverter\Exception\InvalidPartsException;
use Coservas\UuidConverter\Exception\InvalidUuidException;
use Coservas\UuidConverter\Scheme\Unsigned32BitBigEndian;

class Unsigned32BitBigEndianConverter implements SchemeConverterInterface
{
    private const PACK_FORMAT = 'N*'; // unsigned long (always 32 bit, big endian byte order)

    public static function fromUuid(string $uuid): Unsigned32BitBigEndian
    {
        $parts = ConverterHelper::uuidToParts(self::PACK_FORMAT, $uuid);

        return count($parts) < 4
            ? throw new InvalidUuidException($uuid)
            : new Unsigned32BitBigEndian($uuid, $parts[1], $parts[2], $parts[3], $parts[4]);
    }

    public static function fromParts(int ...$parts): Unsigned32BitBigEndian
    {
        $string = ConverterHelper::partsToUuid(self::PACK_FORMAT, ...$parts);

        return $string === ''
            ? throw new InvalidPartsException(...$parts)
            : new Unsigned32BitBigEndian($string, ...$parts);
    }
}