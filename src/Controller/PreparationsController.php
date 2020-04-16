<?php

namespace App\Controller;

use App\Entity\Preparations;
use App\Entity\Recettes;
use App\Form\PreparationsType;
use App\Repository\PreparationsRepository;
use App\Repository\RecettesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/preparations")
 */
class PreparationsController extends AbstractController
{
//    /**
//     * @Route("/", name="preparations_index", methods={"GET"})
//     */
//    public function index(PreparationsRepository $preparationsRepository): Response
//    {
//        return $this->render('preparations/index.html.twig', [
//            'preparations' => $preparationsRepository->findAll(),
//        ]);
//    }

    /**
     * @Route("/new", name="preparations_new", methods={"GET","POST"})
     */
//    public function new(Request $request): Response
//    {
//        $preparation = new Preparations();
//        $form = $this->createForm(PreparationsType::class, $preparation);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($preparation);
//            $entityManager->flush();
//
//            return $this->redirectToRoute('preparations_index');
//        }
//
//        return $this->render('preparations/new.html.twig', [
//            'preparation' => $preparation,
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @Route("/recette/{id}/ajout_etape", name="preparations_show", methods={"GET","POST"})
     */
    public function show(Recettes $recettes, Request $request): Response
    {
        $preparation = new Preparations();
        $form = $this->createForm(PreparationsType::class, $preparation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $preparation->setRecettes($recettes);
            $entityManager->persist($preparation);
            $entityManager->flush();

            return $this->redirectToRoute('recettes_show', ['id'=>$recettes->getid()]);
        }

        return $this->render('compte/preparations/show.html.twig', [
            'recettes' => $recettes,
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/{id}/edit", name="preparations_edit", methods={"GET","POST"})
//     */
//    public function edit(Request $request, Preparations $preparation): Response
//    {
//        $form = $this->createForm(PreparationsType::class, $preparation);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('preparations_index');
//        }
//
//        return $this->render('preparations/edit.html.twig', [
//            'preparation' => $preparation,
//            'form' => $form->createView(),
//        ]);
//    }

//    /**
//     * @Route("/{id}", name="preparations_delete", methods={"DELETE"})
//     */
//    public function delete(Request $request, Preparations $preparation): Response
//    {
//        if ($this->isCsrfTokenValid('delete'.$preparation->getId(), $request->request->get('_token'))) {
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->remove($preparation);
//            $entityManager->flush();
//        }
//
//        return $this->redirectToRoute('preparations_index');
//    }
}
