<?php

namespace App\Controller;

use App\DTO\FundInputDTO;
use App\Entity\Fund;
use App\Entity\FundManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class UpdateFundController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/funds/{fund}', name: 'app_update_fund', methods: ['PUT'])]
    public function index(Fund $fund, #[MapRequestPayload] FundInputDTO $fundData): JsonResponse
    {
        $fund->name = $fundData->name;
        $fund->startYear = $fundData->startYear;
        $fund->aliases = $fundData->aliases;
        $fund->manager = $this->entityManager->getReference(FundManager::class, $fundData->managerId);

        $this->entityManager->flush();

        return $this->json($fund);
    }
}
