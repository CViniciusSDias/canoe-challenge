<?php

namespace App\Message;

final readonly class DuplicateFundWarningMessage
{
    public function __construct(
        public string $fundName,
        public array $fundAliases,
        public string $fundManagerId,
    )
    {
    }
}
