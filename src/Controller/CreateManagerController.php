<?php

namespace App\Controller;

use App\DTO\ManagerCreationDTO;
use App\Entity\FundManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Factory\UlidFactory;

class CreateManagerController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private UlidFactory $ulidFactory)
    {
    }

    #[Route('/managers', name: 'app_create_manager', methods: ['POST'])]
    public function index(#[MapRequestPayload] ManagerCreationDTO $managerData): JsonResponse
    {
        $manager = new FundManager($this->ulidFactory->create(), $managerData->companyName);
        $this->entityManager->persist($manager);
        $this->entityManager->flush();

        return $this->json($manager, Response::HTTP_CREATED);
    }
}
