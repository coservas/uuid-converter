<?php

declare(strict_types=1);

namespace Coservas\UuidConverter\Scheme;

final class Signed64BitBigEndian implements SchemeInterface
{
    /**
     * @param non-empty-string $uuid
     */
    public function __construct(
        private string $uuid,
        private int $firstPart,
        private int $secondPart,
    ) {
    }

    public function getStringUuid(): string
    {
        return $this->uuid;
    }

    public function getIntParts(): array
    {
        return [
            $this->firstPart,
            $this->secondPart,
        ];
    }
}