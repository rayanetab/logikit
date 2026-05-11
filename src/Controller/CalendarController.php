<?php

namespace App\Controller;

use App\Repository\AssignmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CalendarController extends AbstractController
{
    #[Route('/calendar', name: 'app_calendar')]
    #[IsGranted('ROLE_USER')]
    public function index(AssignmentRepository $assignmentRepository): Response
    {
        $assignments = $assignmentRepository->createQueryBuilder('a')
            ->where('a.returned_at IS NOT NULL')
            ->orderBy('a.returned_at', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('calendar/index.html.twig', [
            'assignments' => $assignments,
        ]);
    }
}