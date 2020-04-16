<?php

namespace App\Controller;

use App\Entity\Favoris;
use App\Form\FavorisType;
use App\Repository\FavorisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/favoris")
 */
class FavorisController extends AbstractController
{
    /**
     * @Route("/", name="favoris_index", methods={"GET"})
     */
    public function index(FavorisRepository $favorisRepository): Response
    {
        return $this->render('favoris/index.html.twig', [
            'favoris' => $favorisRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="favoris_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $favori = new Favoris();
        $form = $this->createForm(FavorisType::class, $favori);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($favori);
            $entityManager->flush();

            return $this->redirectToRoute('favoris_index');
        }

        return $this->render('favoris/new.html.twig', [
            'favori' => $favori,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="favoris_show", methods={"GET"})
     */
    public function show(Favoris $favori): Response
    {
        return $this->render('favoris/show.html.twig', [
            'favori' => $favori,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="favoris_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Favoris $favori): Response
    {
        $form = $this->createForm(FavorisType::class, $favori);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('favoris_index');
        }

        return $this->render('favoris/edit.html.twig', [
            'favori' => $favori,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="favoris_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Favoris $favori): Response
    {
        if ($this->isCsrfTokenValid('delete'.$favori->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($favori);
            $entityManager->flush();
        }

        return $this->redirectToRoute('favoris_index');
    }
}
