<?php

namespace App\Controller;
use App\Repository\DiningTableRepository;
use App\Entity\DiningTable;
use App\Entity\Restau;
use App\Form\RestauType;
use App\Repository\RestauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class ClientController extends AbstractController
{
    #[Route('/restaurants', name: 'app_client_restaurants')]
    public function restaurants(RestauRepository $restauRepository): Response
    {
        return $this->render('restau/allRestau.html.twig', [
            'restaus' => $restauRepository->findAll(),
        ]);
    }
    #[Route('restaurant/{id}', name: 'app_restau_show_client', methods: ['GET'])]
    public function show(Restau $restau, EntityManagerInterface $em): Response
    {
        $id = $restau->getId();
        $menus = $restau->getMenus();
        // $DiningTableRepository = $Doctrine->getRepository(DiningTable::class);
        // $tables = $DiningTableRepository->getTablesRestau($id);
        $query = $em->createQuery(
            "SELECT t FROM App\Entity\DiningTable t
            where t.restau =:restauId");
        $query->setParameter('restauId', $id);
        $tables = $query->getResult();
        
        return $this->render('restau/restaurant.html.twig', [
            'restau' => $restau,
            'tables' => $tables,
        ]);
    }
}
