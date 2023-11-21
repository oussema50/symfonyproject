<?php

namespace App\Controller;

use App\Entity\Restau;
use App\Form\RestauType;
use App\Repository\RestauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/restau')]
class RestauController extends AbstractController
{
    #[Route('/', name: 'app_restau_index', methods: ['GET'])]
    public function index(RestauRepository $restauRepository): Response
    {
        return $this->render('restau/index.html.twig', [
            'restaus' => $restauRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_restau_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $restau = new Restau();
        $form = $this->createForm(RestauType::class, $restau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($restau);
            $entityManager->flush();

            return $this->redirectToRoute('app_restau_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('restau/new.html.twig', [
            'restau' => $restau,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_restau_show', methods: ['GET'])]
    public function show(Restau $restau): Response
    {
        return $this->render('restau/show.html.twig', [
            'restau' => $restau,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_restau_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Restau $restau, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RestauType::class, $restau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_restau_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('restau/edit.html.twig', [
            'restau' => $restau,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_restau_delete', methods: ['POST'])]
    public function delete(Request $request, Restau $restau, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restau->getId(), $request->request->get('_token'))) {
            $entityManager->remove($restau);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_restau_index', [], Response::HTTP_SEE_OTHER);
    }
}
