<?php

namespace App\Controller;

use App\Entity\Memo;
use App\Form\MemoType;
use App\Repository\MemoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsCsrfTokenValid;

#[Route('/memo')]
final class MemoController extends AbstractController
{
    public function __construct(
        private readonly MemoRepository $memoRepository,
    ) {
    }

    #[Route('/new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $memo = new Memo();
        $form = $this->createForm(MemoType::class, $memo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->memoRepository->save($memo);

            return $this->redirect('/');
        }

        return $this->render('memo/new.html.twig', [
            'memo' => $memo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(string $id): Response
    {
        return $this->render('memo/show.html.twig', [
            'memo' => $this->findOrFail($id),
        ]);
    }

    #[Route('/{id}/edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, string $id): Response
    {
        $memo = $this->findOrFail($id);
        $form = $this->createForm(MemoType::class, $memo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->memoRepository->save($memo);

            return $this->redirect('/');
        }

        return $this->render('memo/edit.html.twig', [
            'memo' => $memo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', methods: ['POST'])]
    #[IsCsrfTokenValid('delete')]
    public function delete(string $id): Response
    {
        $this->memoRepository->remove($this->findOrFail($id));

        return $this->redirect('/');
    }

    private function findOrFail(string $id): Memo
    {
        return $this->memoRepository->find($id) ?? throw new NotFoundHttpException('Memo not found.');
    }
}
