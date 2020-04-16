<?php

namespace App\Controller;

use App\Entity\Search;
use App\Entity\Users;
use App\Form\SearchType;
use App\Form\UsersType;
use App\Repository\RecettesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/compte")
 */
class CompteController extends AbstractController
{
    /**
     * @Route("/", name="compte")
     */
    public function index()
    {
        return $this->render('compte/compte.html.twig', [
            'controller_name' => 'CompteController',
        ]);
    }

    /**
     * @Route("/users/show{id}", name="users_show", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        return $this->render('compte/users/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/users/{id}/edit", name="users_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Users $user, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->remove('password');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setDateUpdate(new \DateTime());
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('users_show', ['id' => $user->getid()]);
        }

        return $this->render('compte/users/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/recherche", name="search1")
     */
    public function recherche(Request $request, RecettesRepository $repo)
    {

        // $searchForm = $this->createForm(SearchType::class,$search);
        //  $searchForm->handleRequest($request);
        $recettes = $repo->findAll();
        if ($request->isMethod('POST') && $request->request->get('titre') != "") {

            $title = $request->request->get('titre');

            $recettes = $repo->search($title);


            if ($recettes == null) {
                $this->addFlash('erreur', 'Aucun article contenant ce mot clé dans le titre n\'a été trouvé, essayez en un autre.');

            }

        }

        return $this->render('public/recettes/recherche.html.twig', [
            'recettes' => $recettes,
        ]);
    }


}
