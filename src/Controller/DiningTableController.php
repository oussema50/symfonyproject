<?php

namespace App\Controller;

use App\Entity\Restau;
use App\Entity\DiningTable;
use App\Form\DiningTableType;
use App\Repository\DiningTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

#[IsGranted('ROLE_OWNER')]
#[Route('/table')]
class DiningTableController extends AbstractController
{
    #[Route('/', name: 'app_dining_table_index', methods: ['GET'])]
    public function index(DiningTableRepository $diningTableRepository): Response
    {
        
        return $this->render('dining_table/index.html.twig', [
            'dining_tables' => $diningTableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dining_table_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $query = $em->createQuery(
            "SELECT r FROM App\Entity\Restau r 
            where r.client =:userId");
        $query->setParameter('userId', $user);
        $restaus = $query->getResult();
        
        $diningTable = new DiningTable();
        $form = $this->createForm(DiningTableType::class, $diningTable);
        $form->handleRequest($request);

        $selectedRestau = $request->request->get('restau');
        $idRestau = (int)$selectedRestau;
        $queryRestau = $em->createQuery(
            "SELECT r FROM App\Entity\Restau r
            where r.id = :idRestau");
        $queryRestau->setParameter('idRestau', $idRestau);
        $oneRestau = $queryRestau->getResult();
        
        if($form->isSubmitted() && $form->isValid()){
            //var_dump($oneRestau[0]->getId());
            $diningTable->setRestau($oneRestau[0]);
            $em->persist($diningTable);
            $em->flush();
            return $this->redirectToRoute('app_dining_table_index');
        }
            
        return $this->render('dining_table/new.html.twig', [
            'restaus' => $restaus,
            'diningTable'=>$form->createView()
        ]);
    }

    #[Route('/{id}', name: 'app_dining_table_show', methods: ['GET'])]
    public function show(DiningTable $diningTable): Response
    {
        return $this->render('dining_table/show.html.twig', [
            'dining_table' => $diningTable,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dining_table_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DiningTable $diningTable, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DiningTableType::class, $diningTable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dining_table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dining_table/edit.html.twig', [
            'dining_table' => $diningTable,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dining_table_delete', methods: ['POST'])]
    public function delete(Request $request, DiningTable $diningTable, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$diningTable->getId(), $request->request->get('_token'))) {
            $entityManager->remove($diningTable);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dining_table_index', [], Response::HTTP_SEE_OTHER);
    }
}
