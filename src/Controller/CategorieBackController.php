<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieBackController extends AbstractController
{
    #[Route('/categorie/back', name: 'app_categorieBack_index')]
    public function index(): Response
    {
        return $this->render('categorie_back/index.html.twig', [
            'controller_name' => 'CategorieBackController',
        ]);
    }
    #[Route('/new', name: 'app_categorieBack_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorieBack_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('categorie_back/_form.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }
    
}
