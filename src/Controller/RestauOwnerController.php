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
#[IsGranted('ROLE_OWNER')]
#[Route('/restau-owner')]
class RestauOwnerController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('/restau/dashbord.html.twig');
    }
    // #[Route('/restaurant', name: 'app_restau_index', methods: ['GET'])]
    // public function restaurants(RestauRepository $restauRepository): Response
    // {
    //     $user = $this->getUser();
    //     return $this->render('restau/index.html.twig', [
    //         'restaus' => $restauRepository->find()
    //     ]);
    // }
    #[Route('/new', name: 'app_restauowner_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $restau = new Restau();
        $form = $this->createForm(RestauType::class, $restau);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $restau->setClient($user->getId());
            $entityManager->persist($restau);
            $entityManager->flush();

            return $this->redirectToRoute('app_restau_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('restau/new.html.twig', [
            'restau' => $restau,
            'form' => $form,
        ]);
    }
}
