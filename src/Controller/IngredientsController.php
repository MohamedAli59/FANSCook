<?php

namespace App\Controller;

use App\Entity\Ingredients;
use App\Entity\Recettes;
use App\Form\IngredientsType;
use App\Repository\IngredientsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ingredients")
 */
class IngredientsController extends AbstractController
{
//    /**
//     * @Route("/", name="ingredients_index", methods={"GET"})
//     */
//    public function index(IngredientsRepository $ingredientsRepository): Response
//    {
//        return $this->render('ingredients/index.html.twig', [
//            'ingredients' => $ingredientsRepository->findAll(),
//        ]);
//    }

//    /**
//     * @Route("/new", name="ingredients_new", methods={"GET","POST"})
//     */
//    public function new(Request $request): Response
//    {
//        $ingredient = new Ingredients();
//        $form = $this->createForm(IngredientsType::class, $ingredient);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($ingredient);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('ingredients_index');
//        }
//
//        return $this->render('ingredients/new.html.twig', [
//            'ingredient' => $ingredient,
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @Route("/recette/{id}/ajout_ingredient", name="ingredients_show", methods={"GET","POST"})
     */
    public function show(Recettes $recettes, Request $request): Response
    {
        $ingredient = new Ingredients();
        $form = $this->createForm(IngredientsType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ingredient->setRecettes($recettes);
            $entityManager->persist($ingredient);
            $entityManager->flush();

            return $this->redirectToRoute('recettes_show', ['id'=>$recettes->getid()]);
        }

        return $this->render('compte/ingredients/show.html.twig', [
            'recettes' => $recettes,
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/{id}/edit", name="ingredients_edit", methods={"GET","POST"})
//     */
//    public function edit(Request $request, Ingredients $ingredient): Response
//    {
//        $form = $this->createForm(IngredientsType::class, $ingredient);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('ingredients_index');
//        }
//
//        return $this->render('ingredients/edit.html.twig', [
//            'ingredient' => $ingredient,
//            'form' => $form->createView(),
//        ]);
//    }

//    /**
//     * @Route("/{id}", name="ingredients_delete", methods={"DELETE"})
//     */
//    public function delete(Request $request, Ingredients $ingredient): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$ingredient->getId(), $request->request->get('_token'))) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->remove($ingredient);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('ingredients_index');
//    }
}
