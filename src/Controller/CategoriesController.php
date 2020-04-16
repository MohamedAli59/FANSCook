<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Recettes;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/public")
 */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="categories_index", methods={"GET"})
     */
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('public/categories/index.html.twig', [
            'categories' => $categoriesRepository->findAll(),
        ]);
    }

//    /**
//     * @Route("/new", name="categories_new", methods={"GET","POST"})
//     */
//    public function new(Request $request): Response
//    {
//        $category = new Categories();
//        $form = $this->createForm(CategoriesType::class, $category);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($category);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('categories_index');
//        }
//
//        return $this->render('categories/new.html.twig', [
//            'category' => $category,
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @Route("/categories/{id}", name="categories_show", methods={"GET"})
     */
    public function show(Categories $category): Response
    {
        $recettes = $category->getRecettes();
        return $this->render('public/categories/show.html.twig', [
            'category' => $category,
            'recettes' => $recettes,

        ]);
    }

    /**
     * @Route("/recettes/{id}", name="categorie_recettes_show", methods={"GET"})
     */
    public function showRecette(Recettes $recette): Response
    {
        $ingredients = $recette -> getIngredients();
        $preparations = $recette -> getPreparations();
        $category = $recette -> getCategories();

        return $this->render('public/recettes/show.html.twig', [
            'recette' => $recette,
            'ingredients' => $ingredients,
            'preparations' => $preparations,
            'category' => $category
        ]);
    }

//    /**
//     * @Route("/{id}/edit", name="categories_edit", methods={"GET","POST"})
//     */
//    public function edit(Request $request, Categories $category): Response
//    {
//        $form = $this->createForm(CategoriesType::class, $category);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('categories_index');
//        }
//
//        return $this->render('categories/edit.html.twig', [
//            'category' => $category,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{id}", name="categories_delete", methods={"DELETE"})
//     */
//    public function delete(Request $request, Categories $category): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$category->getId(), $request->request->get('_token'))) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->remove($category);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('categories_index');
//    }
}
