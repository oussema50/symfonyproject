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
    #[Route('/restaurants', name: 'app_restau_index', methods: ['GET'])]
    public function restaurants(RestauRepository $restauRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $query = $em->createQuery(
               "SELECT r FROM App\Entity\Restau r 
               where r.client =:userId");
            $query->setParameter('userId', $user);
           $restaus = $query->getResult();
        return $this->render('restau/index.html.twig',['restaus' => $restaus]);
    }
    #[Route('/new', name: 'app_restauowner_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $restau = new Restau();
        $form = $this->createForm(RestauType::class, $restau);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $restau->setClient($user);
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
