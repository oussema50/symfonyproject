<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/menu')]
class MenuController extends AbstractController
{       private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/', name: 'app_menu_index', methods: ['GET'])]
    public function index(MenuRepository $menuRepository): Response
    {
        return $this->render('menu/index.html.twig', [
            'menus' => $menuRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_menu_new', methods: ['GET', 'POST'])]
    public function store(Request $request , EntityManagerInterface $entityManager ): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class,$menu);
        $form->handleRequest($request);
        $user = $this->getUser();
        
        if($form->isSubmitted() && $form->isValid()){
            $menu = $form->getData();
            if($request->files->get('menu')['image']){
                $image = $request->files->get('menu')['image'];
                $image_name = time().'_'.$image->getClientOriginalName();
                $image->move($this->getParameter('image_directory'),$image_name);
                $menu->setImage($image_name);
            }
            if($user){
                $id = $user->getId();
                $menu->setRestau($id);
            }
            // tell Doctrine you want to (eventually) save the Product (no queries yet)
                $this->entityManager->persist($menu);

            // actually executes the queries (i.e. the INSERT query)
            $this->entityManager->flush();
            $this->addFlash(
                'success',
                'Your Menu was saved'
            );
            return $this->redirectToRoute('app_menu_index');
        }

        return $this->renderForm('menu/new.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }
#[Route('/{id}/edit', name: 'app_menu_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, EntityManagerInterface $entityManager, Menu $menu): Response
{
    $form = $this->createForm(MenuType::class, $menu);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle file upload if an image is submitted
        if ($request->files->get('menu')['image']) {
            $image = $request->files->get('menu')['image'];
            $image_name = time() . '_' . $image->getClientOriginalName();
            $image->move($this->getParameter('image_directory'), $image_name);
            $menu->setImage($image_name);
        }

        // Persist and flush the changes to the database
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Your Menu was updated'
        );

        return $this->redirectToRoute('app_menu_index');
    }
    return $this->renderForm('menu/new.html.twig', [
        'menu' => $menu,
        'form' => $form,
    ]);
}
    #[Route('/{id}/delete', name: 'app_menu_delete', methods: ['GET', 'POST'])]
public function delete(Request $request, EntityManagerInterface $entityManager, Menu $menu): Response
{
    if ($this->isCsrfTokenValid('delete'.$menu->getId(), $request->request->get('_token'))) {
        // Remove the image file if it exists
        $imagePath = $this->getParameter('image_directory') .'/'. $menu->getImage();
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Remove the entity
        $entityManager->remove($menu);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Your Menu was deleted'
        );
        
    }
    return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
}

    #[Route('/{id}', name: 'app_menu_show', methods: ['GET', 'POST'])]
    public function show(Menu $menu): Response
    {
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
        ]);
    }

  /*   #[Route('/new', name: 'app_menu_new', methods: ['GET', 'POST'])]
    public function new_no_image(Request $request, EntityManagerInterface $entityManager): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($menu);
            $entityManager->flush();

            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('menu/new.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_menu_edit', methods: ['GET', 'POST'])]
    public function edit_no_image(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('menu/edit.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }

   // #[Route('/{id}', name: 'app_menu_delete', methods: ['POST'])]
   // public function delete_no_image(Request $request, Menu $menu, EntityManagerInterface $entityManager): Response
   // {
       // if ($this->isCsrfTokenValid('delete'.$menu->getId(), $request->request->get('_token'))) {
           // $entityManager->remove($menu);
         //   $entityManager->flush();
       // }

     //   return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
   // }
*/
}