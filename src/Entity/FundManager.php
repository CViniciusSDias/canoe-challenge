<?php

namespace App\Entity;

use App\Repository\FundManagerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;

#[ORM\Entity(repositoryClass: FundManagerRepository::class)]
class FundManager
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'ulid')]
        public ?string $id = null,
        #[ORM\Column(length: 255)]
        public ?string $companyName = null,
        #[ORM\OneToMany(mappedBy: 'manager', targetEntity: Fund::class)]
        private Collection $managedFunds = new ArrayCollection(),
    ) {
    }

    public function managedFunds(): Collection
    {
        return $this->managedFunds;
    }
}
