<?php

namespace App\Controller;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(Request $request, CarRepository $carRepository): Response
    {    $searchTerm = $request->query->get('search'); // Assuming the search term is passed via query parameter

        $results = $carRepository->findByExampleField($searchTerm);
        return $this->render('search/index.html.twig', [
            'results' => $results,
        ]);
    }
}
