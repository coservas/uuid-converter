<?php

declare(strict_types=1);

namespace Coservas\UuidConverter\Converter;

use Coservas\UuidConverter\Exception\InvalidPartsException;
use Coservas\UuidConverter\Exception\InvalidUuidException;
use Coservas\UuidConverter\Scheme\SchemeInterface;

interface SchemeConverterInterface
{
    /**
     * @param non-empty-string $uuid
     *
     * @throws InvalidUuidException
     */
    public static function fromUuid(string $uuid): SchemeInterface;

    /**
     * @throws InvalidPartsException
     */
    public static function fromParts(int ...$parts): SchemeInterface;
}