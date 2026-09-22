<?php

namespace App\Controller;

use App\Entity\Memo;
use App\Repository\MemoRepository;
use App\Request\MemoRequest;
use App\Response\MemoResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/memos')]
final class MemoController extends AbstractController
{
    public function __construct(
        private readonly MemoRepository $memoRepository,
    ) {
    }

    #[Route('', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $memos = array_map(
            MemoResponse::fromEntity(...),
            $this->memoRepository->findAllOrderedByCreatedAtDesc(),
        );

        return $this->json($memos);
    }

    #[Route('', methods: ['POST'])]
    public function create(#[MapRequestPayload] MemoRequest $payload): JsonResponse
    {
        $memo = new Memo();
        $memo->setTitle($payload->title);
        $memo->setDescription($payload->description);

        $this->memoRepository->save($memo);

        return $this->json(MemoResponse::fromEntity($memo), Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(string $id): JsonResponse
    {
        $memo = $this->memoRepository->find($id) ?? throw new NotFoundHttpException('Memo not found.');

        return $this->json(MemoResponse::fromEntity($memo));
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(string $id, #[MapRequestPayload] MemoRequest $payload): JsonResponse
    {
        $memo = $this->memoRepository->find($id) ?? throw new NotFoundHttpException('Memo not found.');

        $memo->setTitle($payload->title);
        $memo->setDescription($payload->description);

        $this->memoRepository->save($memo);

        return $this->json(MemoResponse::fromEntity($memo));
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(string $id): Response
    {
        $memo = $this->memoRepository->find($id) ?? throw new NotFoundHttpException('Memo not found.');

        $this->memoRepository->remove($memo);

        return new Response(status: Response::HTTP_NO_CONTENT);
    }
}
