<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Recettes;
use App\Form\SearchType;
use App\Form\UsersType;
use App\Repository\ArticlesRepository;
use App\Repository\IngredientsRepository;
use App\Repository\PreparationsRepository;
use App\Repository\RecettesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/public")
 */
class PublicController extends AbstractController
{
    /**
     * @Route("/", name="public")
     */
    public function index()
    {
        return $this->render('public/public.html.twig', [
            'controller_name' => 'PublicController',
        ]);
    }
    /**
     * @Route("/articles/liste", name="articles_index", methods={"GET"})
     */
    public function indexArticles(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('public/articles/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/recherche", name="search")
     */
    public function search(RecettesRepository $recettesRepository): Response
    {
        return $this->render('public/recettes/recherche.html.twig', [
            'recettes' => $recettesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login()
    {
        return $this->render('public/users/login.html.twig');
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
        return $this->render('public/public.html.twig');
    }

    /**
     * @Route("/users/new", name="users_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash)
            ->addRoles('ROLE_USER');
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('public/users/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/recettes/{id}", name="public_recettes_show", methods={"GET"})
     */
    public function show(Recettes $recette, PreparationsRepository $preparationsRepository): Response
    {
        $ingredients = $recette -> getIngredients();
        $preparations = $preparationsRepository -> getPreparationOrderByOrdre($recette -> getId());
        $category = $recette -> getCategories();

        return $this->render('public/recettes/show.html.twig', [
            'recette' => $recette,
            'ingredients' => $ingredients,
            'preparations' => $preparations,
            'category' => $category
        ]);
    }

    /**
     * @Route("/recherche", name="search")
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
