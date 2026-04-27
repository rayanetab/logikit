<?php

namespace App\Controller;

use App\Entity\Consumable;
use App\Form\ConsumableType;
use App\Repository\ConsumableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/consumable')]
final class ConsumableController extends AbstractController
{
    #[Route(name: 'app_consumable_index', methods: ['GET'])]
    public function index(ConsumableRepository $consumableRepository): Response
    {
        return $this->render('consumable/index.html.twig', [
            'consumables' => $consumableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_consumable_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $consumable = new Consumable();
        $form = $this->createForm(ConsumableType::class, $consumable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($consumable);
            $entityManager->flush();

            return $this->redirectToRoute('app_consumable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('consumable/new.html.twig', [
            'consumable' => $consumable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consumable_show', methods: ['GET'])]
    public function show(Consumable $consumable): Response
    {
        return $this->render('consumable/show.html.twig', [
            'consumable' => $consumable,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_consumable_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Consumable $consumable, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConsumableType::class, $consumable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_consumable_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('consumable/edit.html.twig', [
            'consumable' => $consumable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consumable_delete', methods: ['POST'])]
    public function delete(Request $request, Consumable $consumable, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consumable->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($consumable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_consumable_index', [], Response::HTTP_SEE_OTHER);
    }
}