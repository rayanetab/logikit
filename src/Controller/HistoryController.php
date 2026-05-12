<?php

namespace App\Controller;

use App\Repository\HistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HistoryController extends AbstractController
{
    #[Route('/history', name: 'app_history')]
    #[IsGranted('ROLE_USER')]
    public function index(HistoryRepository $historyRepository, Request $request): Response
    {
        $search = $request->query->get('search');

        if ($search) {
            $histories = $historyRepository->createQueryBuilder('h')
                ->leftJoin('h.user', 'u')
                ->leftJoin('h.asset', 'a')
                ->where('h.action LIKE :search OR u.nom LIKE :search OR u.prenom LIKE :search OR a.brand LIKE :search OR a.model LIKE :search')
                ->setParameter('search', '%' . $search . '%')
                ->orderBy('h.date', 'DESC')
                ->getQuery()
                ->getResult();
        } else {
            $histories = $historyRepository->findBy([], ['date' => 'DESC']);
        }

        return $this->render('history/index.html.twig', [
            'histories' => $histories,
            'search' => $search,
        ]);
    }
}