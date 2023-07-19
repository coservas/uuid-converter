<?php

declare(strict_types=1);

namespace Coservas\UuidConverter\Converter;

use Coservas\UuidConverter\Exception\InvalidPartsException;
use Coservas\UuidConverter\Exception\InvalidUuidException;
use Coservas\UuidConverter\Scheme\Signed64BitBigEndian;

class Signed64BitBigEndianConverter implements SchemeConverterInterface
{
    private const PACK_FORMAT = 'J*'; // (un)signed long long (always 64 bit, big endian byte order)

    public static function fromUuid(string $uuid): Signed64BitBigEndian
    {
        $parts = ConverterHelper::uuidToParts(self::PACK_FORMAT, $uuid);

        return count($parts) < 2
            ? throw new InvalidUuidException($uuid)
            : new Signed64BitBigEndian($uuid, $parts[1], $parts[2]);
    }

    public static function fromParts(int ...$parts): Signed64BitBigEndian
    {
        $string = ConverterHelper::partsToUuid(self::PACK_FORMAT, ...$parts);

        return $string === ''
            ? throw new InvalidPartsException(...$parts)
            : new Signed64BitBigEndian($string, ...$parts);
    }
}