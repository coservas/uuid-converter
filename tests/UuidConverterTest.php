<?php

declare(strict_types=1);

namespace Test\Coservas\UuidConverter;

use Coservas\UuidConverter\ConverterType;
use Coservas\UuidConverter\Exception\ConverterNotFoundException;
use Coservas\UuidConverter\Exception\InvalidPartsException;
use Coservas\UuidConverter\Exception\InvalidUuidException;
use Coservas\UuidConverter\UuidConverter;
use PHPUnit\Framework\TestCase;

class UuidConverterTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testFromUuid(int $type, string $uuid, array $parts): void
    {
        $convertedUuid = UuidConverter::fromUuid($type, $uuid); // @phpstan-ignore-line

        self::assertEquals($uuid, $convertedUuid->getStringUuid());
        self::assertEquals($parts, $convertedUuid->getIntParts());
    }

    /**
     * @dataProvider positiveDataProvider
     */
    public function testFromParts(int $type, string $uuid, array $parts): void
    {
        $convertedUuid = UuidConverter::fromParts($type, ...$parts); // @phpstan-ignore-line

        self::assertEquals(strtolower($uuid), $convertedUuid->getStringUuid());
        self::assertEquals($parts, $convertedUuid->getIntParts());
    }

    public function positiveDataProvider(): array
    {
        return [
            [
                'type'  => ConverterType::SIGNED_64_BIT_BIG_ENDIAN,
                'uuid'  => '9fe0b92c-7ced-4ef8-a729-73455c904cd8',
                'parts' => [
                    -6926332626170196232,
                    -6401458653587551016,
                ],
            ],
            [
                'type'  => ConverterType::SIGNED_64_BIT_BIG_ENDIAN,
                'uuid'  => strtoupper('9fe0b92c-7ced-4ef8-a729-73455c904cd8'),
                'parts' => [
                    -6926332626170196232,
                    -6401458653587551016,
                ],
            ],
            [
                'type'  => ConverterType::UNSIGNED_32_BIT_BIG_ENDIAN,
                'uuid'  => 'f4639445-c5a8-475a-a220-121f5e55cb46',
                'parts' => [
                    4100166725,
                    3316139866,
                    2720010783,
                    1582680902,
                ],
            ],
            [
                'type'  => ConverterType::UNSIGNED_32_BIT_BIG_ENDIAN,
                'uuid'  => strtoupper('f4639445-c5a8-475a-a220-121f5e55cb46'),
                'parts' => [
                    4100166725,
                    3316139866,
                    2720010783,
                    1582680902,
                ],
            ],
        ];
    }

    /**
     * @dataProvider fromUuidNegativeDataProvider
     */
    public function testFromUuidExceptions(string $exception, int $type, string $uuid): void
    {
        self::expectException($exception);
        UuidConverter::fromUuid($type, $uuid);
    }

    public function fromUuidNegativeDataProvider(): array
    {
        return [
            [
                'exception' => ConverterNotFoundException::class,
                'type'      => 0,
                'uuid'      => '',
            ],
            [
                'exception' => InvalidUuidException::class,
                'type'      => ConverterType::SIGNED_64_BIT_BIG_ENDIAN,
                'uuid'      => '0',
            ],
            [
                'exception' => InvalidUuidException::class,
                'type'      => ConverterType::UNSIGNED_32_BIT_BIG_ENDIAN,
                'uuid'      => '0',
            ],
        ];
    }

    /**
     * @dataProvider fromPartsNegativeDataProvider
     */
    public function testFromPartsExceptions(string $exception, int $type, array $parts): void
    {
        self::expectException($exception);
        UuidConverter::fromParts($type, ...$parts);
    }

    public function fromPartsNegativeDataProvider(): array
    {
        return [
            [
                'exception' => ConverterNotFoundException::class,
                'type'      => 0,
                'parts'     => [],
            ],
            [
                'exception' => InvalidPartsException::class,
                'type'      => ConverterType::UNSIGNED_32_BIT_BIG_ENDIAN,
                'parts'     => [1, 2],
            ],
            [
                'exception' => InvalidPartsException::class,
                'type'      => ConverterType::SIGNED_64_BIT_BIG_ENDIAN,
                'parts'     => [1, 2, 3, 4],
            ],
        ];
    }
}