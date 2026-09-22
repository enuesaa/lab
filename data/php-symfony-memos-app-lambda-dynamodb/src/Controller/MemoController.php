<?php

namespace App\Controller;

use App\Entity\Memo;
use App\Exception\ValidationFailedException;
use App\Repository\MemoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/memos')]
final class MemoController extends AbstractController
{
    public function __construct(
        private readonly MemoRepository $memoRepository,
        private readonly ValidatorInterface $validator,
    ) {
    }

    #[Route('', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $memos = array_map(
            $this->toArray(...),
            $this->memoRepository->findAllOrderedByCreatedAtDesc(),
        );

        return $this->json($memos);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $memo = new Memo();
        $this->applyPayload($memo, $request);
        $this->validate($memo);

        $this->memoRepository->save($memo);

        return $this->json($this->toArray($memo), Response::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(string $id): JsonResponse
    {
        return $this->json($this->toArray($this->findOrFail($id)));
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Request $request, string $id): JsonResponse
    {
        $memo = $this->findOrFail($id);
        $this->applyPayload($memo, $request);
        $this->validate($memo);

        $this->memoRepository->save($memo);

        return $this->json($this->toArray($memo));
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(string $id): Response
    {
        $this->memoRepository->remove($this->findOrFail($id));

        return new Response(status: Response::HTTP_NO_CONTENT);
    }

    private function applyPayload(Memo $memo, Request $request): void
    {
        $data = $request->toArray();

        if (\array_key_exists('title', $data)) {
            $memo->setTitle($this->stringField($data['title'], 'title'));
        }

        if (\array_key_exists('description', $data)) {
            $memo->setDescription($this->stringField($data['description'], 'description'));
        }
    }

    private function stringField(mixed $value, string $field): string
    {
        if (!\is_string($value)) {
            throw new BadRequestHttpException(\sprintf('"%s" must be a string.', $field));
        }

        return $value;
    }

    private function validate(Memo $memo): void
    {
        $violations = $this->validator->validate($memo);

        if (\count($violations) > 0) {
            throw new ValidationFailedException($violations);
        }
    }

    private function findOrFail(string $id): Memo
    {
        return $this->memoRepository->find($id) ?? throw new NotFoundHttpException('Memo not found.');
    }

    /**
     * @return array{id: ?string, title: ?string, description: ?string, created_at: ?string, updated_at: ?string}
     */
    private function toArray(Memo $memo): array
    {
        return [
            'id' => $memo->getId(),
            'title' => $memo->getTitle(),
            'description' => $memo->getDescription(),
            'created_at' => $memo->getCreatedAt()?->format(\DATE_ATOM),
            'updated_at' => $memo->getUpdatedAt()?->format(\DATE_ATOM),
        ];
    }
}
