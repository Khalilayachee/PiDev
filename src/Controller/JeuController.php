<?php

namespace App\Controller;

use App\Entity\Jeu;
use App\Form\JeuType;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JeuController extends AbstractController
{

    #[Route('/addjeu', name: 'addjeu')]
    public function addjeu(Request $request): Response
    {
        $jeu = new Jeu();
        $form = $this->createForm(jeuType::class,$jeu);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $images = $form->get('images')->getData();
            if ($images) 
            {
                $imagesName = uniqid().'.'.$images->guessExtension();
                $images->move(
                    $this->getParameter('upload_directory'),
                    $imagesName
                );
                $jeu->setImages($imagesName); // Assurez-vous que votre entité a une méthode setFile pour stocker le chemin du fichier
            }
            
            $en =$this->getDoctrine()->getManager();
            $en->persist($jeu);//Add
            $en->flush();

            return $this->redirectToRoute(route:'afficherJeu');
        }
        return $this->render('jeu/createjeu.html.twig', ['form' => $form->createView()]);

    }
    #[Route('/delete/{id}', name: 'delete_jeu')]
    public function deleteJeu(Request $request, Jeu $jeu): Response
    {
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->remove($jeu);
    $entityManager->flush();

    return $this->redirectToRoute('afficherJeu');
    }

    
    #[Route('/afficherjeu', name: 'afficherJeu')]
public function afficherJeu(): Response
{
    $jeuRepository = $this->getDoctrine()->getRepository(Jeu::class);
    $jeux = $jeuRepository->findAll();

    return $this->render('jeu/afficherjeu.html.twig', [
        'jeux' => $jeux,
    ]);
}

    
}
