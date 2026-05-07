<?php

namespace App\Controller;

use App\Repository\AssetRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request, AssetRepository $assetRepository, UserRepository $userRepository): Response
    {
        $query = $request->query->get('q');
        $assets = [];
        $users = [];

        if ($query) {
            $assets = $assetRepository->createQueryBuilder('a')
                ->where('a.brand LIKE :query OR a.model LIKE :query OR a.serial_number LIKE :query')
                ->setParameter('query', '%' . $query . '%')
                ->getQuery()
                ->getResult();

            $users = $userRepository->createQueryBuilder('u')
                ->where('u.nom LIKE :query OR u.prenom LIKE :query OR u.email LIKE :query')
                ->setParameter('query', '%' . $query . '%')
                ->getQuery()
                ->getResult();
        }

        return $this->render('search/index.html.twig', [
            'query' => $query,
            'assets' => $assets,
            'users' => $users,
        ]);
    }
}