<?php

namespace App\Controller;

use App\Entity\Ingredients;
use App\Entity\Preparations;
use App\Entity\Recettes;
use App\Form\RecettesType;
use App\Repository\PreparationsRepository;
use App\Repository\RecettesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/recettes")
 */
class RecettesController extends AbstractController
{
    /**
     * @Route("/liste", name="recettes_index", methods={"GET"})
     */
    public function index(RecettesRepository $recettesRepository): Response
    {
        return $this->render('admin/recettes/index.html.twig', [
            'recettes' => $recettesRepository->findAll(),
        ]);
    }


    /**
     * @Route("/compte/recette/new", name="recettes_new", methods={"GET","POST"})
     * * @param Request $request
     * @param SluggerInterface $slugger
     * @return Response
     */
    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $recette = new Recettes();
        $form = $this->createForm(RecettesType::class, $recette);
        $form->remove('top_recette');
        $form->remove('save');
        $form->remove('ingredients');
        $form->remove('preparations');
        $form->handleRequest($request);
        $users = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();

            if($file){
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($filename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
            $entityManager = $this->getDoctrine()->getManager();
            $recette->setImage($newFilename);
            $recette->setUsers($users);
            $entityManager->persist($recette);
            $entityManager->flush();

            return $this->redirectToRoute('recettes_show',['id'=>$recette->getid()]);
        }

        return $this->render('compte/recettes/new.html.twig', [
            'recette' => $recette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/compte/recettes/{id}", name="recettes_show", methods={"GET"})
     */
    public function show(Recettes $recette,PreparationsRepository $preparationsRepository): Response
    {

        $ingredients = $recette -> getIngredients();
        $preparations = $preparationsRepository -> getPreparationOrderByOrdre($recette -> getId());
        $category = $recette -> getCategories();

        return $this->render('compte/recettes/show.html.twig', [
            'recette' => $recette,
            'ingredients' => $ingredients,
            'preparations' => $preparations,
            'category' => $category
        ]);
    }

    /**
     * @Route("/recette/{id}/edit", name="admin_recettes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Recettes $recettes, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(RecettesType::class, $recettes);
        $form->remove('users');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image')->getData();
            if($file){
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($filename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }
            $this->getDoctrine()->getManager()->flush();
            $entityManager = $this->getDoctrine()->getManager();
            $recettes->setImage($newFilename)
                ->setDateUpdate(new \DateTime());
            $entityManager->persist($recettes);
            $entityManager->flush();

            return $this->redirectToRoute('admin_recettes_show', ['id'=>$recettes->getid()]);
        }

        return $this->render('admin/recettes/edit.html.twig', [
            'recettes' => $recettes,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="recettes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Recettes $recette): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recette->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recettes_index');
    }



}
