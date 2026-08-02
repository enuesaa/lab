<?php

namespace App\Controller;

use App\Entity\Memo;
use App\Form\MemoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/memo')]
final class MemoController extends AbstractController
{
    #[Route('/new', name: 'app_memo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $memo = new Memo();
        $form = $this->createForm(MemoType::class, $memo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($memo);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('memo/new.html.twig', [
            'memo' => $memo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_memo_show', methods: ['GET'])]
    public function show(Memo $memo): Response
    {
        return $this->render('memo/show.html.twig', [
            'memo' => $memo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_memo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Memo $memo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MemoType::class, $memo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('memo/edit.html.twig', [
            'memo' => $memo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_memo_delete', methods: ['POST'])]
    public function delete(Request $request, Memo $memo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$memo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($memo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
