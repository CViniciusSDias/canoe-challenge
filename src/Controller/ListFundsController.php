<?php

namespace App\Controller;

use App\Repository\FundRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListFundsController extends AbstractController
{
    public function __construct(private FundRepository $managerRepository)
    {
    }

    #[Route('/funds', name: 'app_list_funds', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $queryData = $request->query->all();
        $allowedParams = ['name', 'startYear', 'managerId', 'alias', 'limit', 'offset'];
        $diff = array_diff(array_keys($queryData), $allowedParams);
        if (!empty($diff)) {
            return $this->json([
                'error' => 'Invalid query parameters',
                'allowed' => $allowedParams
            ], 400);
        }
        $limit = $queryData['limit'] ?? 10;
        unset($queryData['limit']);
        $offset = $queryData['offset'] ?? 0;
        unset($queryData['offset']);

        $managers = $this->managerRepository->findBy($queryData, limit: $limit, offset: $offset);

        return $this->json($managers);
    }
}
