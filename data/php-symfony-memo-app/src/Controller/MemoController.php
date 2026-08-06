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
use Symfony\Component\ExpressionLanguage\Expression;

#[Route('/memo')]
final class MemoController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
    ){}

    // これいちおう make:crud で生成されたコードっぽい
    // https://qiita.com/ippey_s/items/be50ff0294837b8f8b1f
    #[Route('/new', name: 'app_memo_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $memo = new Memo();
        $form = $this->createForm(MemoType::class, $memo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($memo);
            $this->entityManager->flush();

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
    public function edit(Request $request, Memo $memo): Response
    {
        $form = $this->createForm(MemoType::class, $memo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('memo/edit.html.twig', [
            'memo' => $memo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_memo_delete', methods: ['POST'])]
    #[IsCsrfTokenValid(new Expression('"delete" ~ args["memo"].getId()'))]
    public function delete(Memo $memo): Response
    {
        $this->entityManager->remove($memo);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
