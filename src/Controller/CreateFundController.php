<?php

namespace App\Controller;

use App\DTO\FundCreationDTO;
use App\Entity\Fund;
use App\Repository\FundManagerRepository;
use App\Repository\FundRepository;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Factory\UlidFactory;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateFundController extends AbstractController
{
    public function __construct(
        private FundRepository $fundRepository,
        private FundManagerRepository $managerRepository,
        private ValidatorInterface $validator,
        private UlidFactory $ulidFactory
    ) {
    }

    #[Route('/funds', name: 'app_create_fund', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        $requestData = $request->toArray();
        $dto = new FundCreationDTO(
            $requestData['name'] ?? '',
            $requestData['startYear'] ?? 0,
            $requestData['managerId'] ?? '',
            $requestData['aliases'] ?? [],
        );
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $year = \DateTimeImmutable::createFromFormat('Y', $dto->startYear);
        if ($year === false || $dto->startYear > (int) date('Y')) {
            throw new UnprocessableEntityHttpException('Invalid start year. The year must be valid and before the current year.');
        }

        $manager = $this->managerRepository->find($dto->managerId);

        $this->fundRepository->doesFundAlreadyExist($dto->name, $dto->aliases, $manager->id);
        $fund = new Fund($this->ulidFactory->create(), $dto->name, $dto->startYear, $manager, $dto->aliases);
        $this->fundRepository->add($fund);

        return $this->json($fund, Response::HTTP_CREATED);
    }
}
