<?php

namespace App\Controller;

use App\DTO\ManagerCreationDTO;
use App\Entity\FundManager;
use App\Repository\FundManagerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Factory\UlidFactory;

class ListManagersController extends AbstractController
{
    public function __construct(private FundManagerRepository $managerRepository)
    {
    }

    #[Route('/managers', name: 'app_list_managers', methods: ['GET'])]
    public function index(#[MapQueryParameter] int $offset = 0): JsonResponse
    {
        $managers = $this->managerRepository->paginated($offset);

        return $this->json($managers);
    }
}
