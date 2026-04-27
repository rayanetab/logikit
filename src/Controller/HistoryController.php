<?php

namespace App\Controller;

use App\Repository\HistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HistoryController extends AbstractController
{
    #[Route('/history', name: 'app_history')]
    #[IsGranted('ROLE_USER')]
    public function index(HistoryRepository $historyRepository): Response
    {
        $histories = $historyRepository->findBy([], ['date' => 'DESC']);

        return $this->render('history/index.html.twig', [
            'histories' => $histories,
        ]);
    }
}