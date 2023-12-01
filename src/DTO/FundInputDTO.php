<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Fund;
use Symfony\Component\Validator\Constraints as Assert;

readonly class FundInputDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $name,
        #[Assert\NotBlank]
        #[Assert\Regex(pattern: '/^\d{4}$/')]
        public int $startYear,
        #[Assert\NotBlank]
        #[Assert\Ulid]
        public string $managerId,
        #[Assert\All([
            new Assert\NotBlank()
        ])]
        public array $aliases,
    )
    {
    }
}
