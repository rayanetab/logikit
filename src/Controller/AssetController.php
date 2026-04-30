<?php

namespace App\Controller;

use App\Entity\Asset;
use App\Form\AssetType;
use App\Repository\AssetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/asset')]
final class AssetController extends AbstractController
{
#[Route(name: 'app_asset_index', methods: ['GET'])]
public function index(AssetRepository $assetRepository, Request $request): Response
{
    $page = $request->query->getInt('page', 1);
    $limit = 5;
    $offset = ($page - 1) * $limit;
    
    $category = $request->query->get('category');
    $status = $request->query->get('status');
    $sort = $request->query->get('sort', 'id');
    $order = $request->query->get('order', 'DESC');

    $criteria = [];
    if ($category) $criteria['Category'] = $category;
    if ($status) $criteria['status'] = $status;

    $assets = $assetRepository->findBy($criteria, [$sort => $order], $limit, $offset);
    $total = count($assetRepository->findBy($criteria));
    $totalPages = ceil($total / $limit);

    return $this->render('asset/index.html.twig', [
        'assets' => $assets,
        'currentPage' => $page,
        'totalPages' => $totalPages,
        'currentCategory' => $category,
        'currentStatus' => $status,
        'currentSort' => $sort,
        'currentOrder' => $order,
    ]);
}
    #[Route('/new', name: 'app_asset_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $asset = new Asset();
        $form = $this->createForm(AssetType::class, $asset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($asset);
            $entityManager->flush();

            return $this->redirectToRoute('app_asset_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('asset/new.html.twig', [
            'asset' => $asset,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_asset_show', methods: ['GET'])]
    public function show(Asset $asset): Response
    {
        return $this->render('asset/show.html.twig', [
            'asset' => $asset,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_asset_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Asset $asset, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssetType::class, $asset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_asset_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('asset/edit.html.twig', [
            'asset' => $asset,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_asset_delete', methods: ['POST'])]
    public function delete(Request $request, Asset $asset, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$asset->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($asset);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_asset_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/{id}/transition/{transition}', name: 'app_asset_transition', methods: ['GET'])]
public function transition(Asset $asset, string $transition, \Symfony\Component\Workflow\WorkflowInterface $assetStatusStateMachine, \Doctrine\ORM\EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\Response
{
    if ($assetStatusStateMachine->can($asset, $transition)) {
        $assetStatusStateMachine->apply($asset, $transition);
        $entityManager->flush();
        $this->addFlash('success', 'Statut mis à jour avec succès !');
    } else {
        $this->addFlash('error', 'Transition non autorisée.');
    }

    return $this->redirectToRoute('app_asset_show', ['id' => $asset->getId()]);
}
    #[Route('/{id}/qrcode', name: 'app_asset_qrcode', methods: ['GET'])]
    public function qrcode(Asset $asset): Response
    {
    $qrCode = \Endroid\QrCode\QrCode::create(
        'Série: ' . $asset->getSerialNumber() . 
        ' | Marque: ' . $asset->getBrand() . 
        ' | Modèle: ' . $asset->getModel()
    );
    $qrCode->setSize(200);
    $qrCode->setMargin(10);

    $writer = new \Endroid\QrCode\Writer\PngWriter();
    $result = $writer->write($qrCode);

    return new Response($result->getString(), 200, [
        'Content-Type' => 'image/png',
    ]);
}

}
