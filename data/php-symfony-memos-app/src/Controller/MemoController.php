<?php

namespace App\Controller;

use App\Entity\Memo;
use App\Form\MemoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsCsrfTokenValid;

#[Route('/memo')]
final class MemoController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
    ){}

    #[Route('/new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $memo = new Memo();
        $form = $this->createForm(MemoType::class, $memo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($memo);
            $this->entityManager->flush();

            return $this->redirect('/');
        }

        return $this->render('memo/new.html.twig', [
            'memo' => $memo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(Memo $memo): Response
    {
        return $this->render('memo/show.html.twig', [
            'memo' => $memo,
        ]);
    }

    #[Route('/{id}/edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Memo $memo): Response
    {
        $form = $this->createForm(MemoType::class, $memo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirect('/');
        }

        return $this->render('memo/edit.html.twig', [
            'memo' => $memo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', methods: ['POST'])]
    #[IsCsrfTokenValid('delete')]
    public function delete(Memo $memo): Response
    {
        $this->entityManager->remove($memo);
        $this->entityManager->flush();

        return $this->redirect('/');
    }
}
