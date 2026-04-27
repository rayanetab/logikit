<?php

namespace App\Controller;

use App\Entity\Assignment;
use App\Entity\History;
use App\Form\AssignmentType;
use App\Repository\AssignmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/assignment')]
final class AssignmentController extends AbstractController
{
    #[Route(name: 'app_assignment_index', methods: ['GET'])]
    public function index(AssignmentRepository $assignmentRepository): Response
    {
        return $this->render('assignment/index.html.twig', [
            'assignments' => $assignmentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_assignment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, \Symfony\Component\Workflow\WorkflowInterface $assetStatusStateMachine): Response
    {
        $assignment = new Assignment();
        $form = $this->createForm(AssignmentType::class, $assignment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Si un asset est sélectionné, changer son statut à "assigned"
            if ($assignment->getAsset() !== null) {
                $asset = $assignment->getAsset();
                if ($assetStatusStateMachine->can($asset, 'assign')) {
                    $assetStatusStateMachine->apply($asset, 'assign');
                }
            }

            // Si un consommable est sélectionné, diminuer le stock
            if ($assignment->getConsumable() !== null) {
                $consumable = $assignment->getConsumable();
                $consumable->setStockQuantity($consumable->getStockQuantity() - 1);
            }

            // Enregistrer dans l'historique
            $history = new History();
            $history->setUser($this->getUser());
            $history->setAsset($assignment->getAsset());
            $history->setAction('Attribution créée pour ' . $assignment->getUser()->getPrenom() . ' ' . $assignment->getUser()->getNom());
            $history->setDate(new \DateTimeImmutable());
            $entityManager->persist($history);

            $entityManager->persist($assignment);
            $entityManager->flush();

            $this->addFlash('success', 'Attribution créée avec succès !');
            return $this->redirectToRoute('app_assignment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assignment/new.html.twig', [
            'assignment' => $assignment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assignment_show', methods: ['GET'])]
    public function show(Assignment $assignment): Response
    {
        return $this->render('assignment/show.html.twig', [
            'assignment' => $assignment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_assignment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Assignment $assignment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssignmentType::class, $assignment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_assignment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('assignment/edit.html.twig', [
            'assignment' => $assignment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_assignment_delete', methods: ['POST'])]
    public function delete(Request $request, Assignment $assignment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$assignment->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($assignment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_assignment_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/pdf', name: 'app_assignment_pdf', methods: ['GET'])]
    public function generatePdf(Assignment $assignment, \App\Service\PdfService $pdfService): Response
    {
        $pdf = $pdfService->generateDecharge($assignment);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="decharge_' . $assignment->getId() . '.pdf"',
        ]);
    }
}