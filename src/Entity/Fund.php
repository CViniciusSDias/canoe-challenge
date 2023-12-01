<?php

namespace App\Entity;

use App\Repository\FundRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: FundRepository::class)]
readonly class Fund
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: "ulid")]
        public ?string $id = null,
        #[ORM\Column(length: 255)]
        public ?string $name = null,
        #[ORM\Column(type: Types::SMALLINT)]
        public ?int $startYear = null,
        #[ORM\ManyToOne(inversedBy: 'managedFunds')]
        #[ORM\JoinColumn(nullable: false)]
        public ?FundManager $manager = null,
        #[ORM\Column(type: Types::JSON, options: ['jsonb' => true])]
        public array $aliases = [],
    )
    {
    }
}
