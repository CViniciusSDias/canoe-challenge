<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Fund;
use Symfony\Component\Validator\Constraints as Assert;

readonly class ManagerCreationDTO
{
    public function __construct(
        #[Assert\NotBlank]
        public string $companyName,
    )
    {
    }
}
