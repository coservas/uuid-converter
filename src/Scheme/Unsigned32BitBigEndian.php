<?php

declare(strict_types=1);

namespace Coservas\UuidConverter\Scheme;

final class Unsigned32BitBigEndian implements SchemeInterface
{
    /**
     * @param non-empty-string $uuid
     */
    public function __construct(
        private string $uuid,
        private int $firstPart,
        private int $secondPart,
        private int $thirdPart,
        private int $fourthPart,
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
            $this->thirdPart,
            $this->fourthPart,
        ];
    }
}