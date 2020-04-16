<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Recettes;
use App\Entity\Preparations;
use App\Entity\Ingredients;
use App\Entity\Articles;
use App\Form\UsersType;
use App\Form\RecettesType;
use App\Form\PreparationsType;
use App\Form\IngredientsType;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use App\Repository\PreparationsRepository;
use App\Repository\UsersRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin")
     */
    public function indexAdmin()
    {
        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/users/liste", name="admin_users_index", methods={"GET"})
     */
    public function indexUsers(UsersRepository $usersRepository): Response
    {
        return $this->render('admin/users/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }
    /**
     * @Route("/articles/liste", name="admin_articles_index", methods={"GET"})
     */
    public function indexArticles(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('admin/articles/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
        ]);
    }


    /**
     * @Route("/users/show{id}", name="admin_users_show", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        return $this->render('admin/users/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/recettes/show{id}", name="admin_recettes_show", methods={"GET"})
     */
    public function showRecette(Recettes $recette, PreparationsRepository $preparationsRepository): Response
    {
        $ingredients = $recette -> getIngredients();
        $preparations = $preparationsRepository -> getPreparationOrderByOrdre($recette -> getId());
        $category = $recette -> getCategories();

        return $this->render('admin/recettes/show.html.twig', [
            'recette' => $recette,
            'ingredients' => $ingredients,
            'preparations' => $preparations,
            'category' => $category
        ]);
    }

    /**
     * @Route("/recettes_en_cours/show{id}", name="admin_recettes_showtwo", methods={"GET"})
     */
    public function showtwo(Recettes $recette): Response
    {
        $ingredients = $recette -> getIngredients();
        $preparations = $recette -> getPreparations();
        $category = $recette -> getCategories();

        return $this->render('admin/recettes/showtwo.html.twig', [
            'recette' => $recette,
            'ingredients' => $ingredients,
            'preparations' => $preparations,
            'category' => $category
        ]);
    }

    /**
     * @Route("/recette/{id}/ajout_etape", name="admin_preparations_show", methods={"GET","POST"})
     */
    public function showPrepa(Recettes $recettes, Request $request): Response
    {
        $preparation = new Preparations();
        $form = $this->createForm(PreparationsType::class, $preparation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $preparation->setRecettes($recettes)
                ->setDateUpdate(new \DateTime());
            $entityManager->persist($preparation);
            $entityManager->flush();

            return $this->redirectToRoute('admin_recettes_showtwo', ['id'=>$recettes->getid()]);
        }

        return $this->render('admin/preparations/show.html.twig', [
            'recettes' => $recettes,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/recette/{id}/ajout_ingredient", name="admin_ingredients_show", methods={"GET","POST"})
     */
    public function showIngre(Recettes $recettes, Request $request): Response
    {
        $ingredient = new Ingredients();
        $form = $this->createForm(IngredientsType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ingredient->setRecettes($recettes)
            ->setDateUpdate(new \DateTime());
            $entityManager->persist($ingredient);
            $entityManager->flush();

            return $this->redirectToRoute('admin_recettes_showtwo', ['id'=>$recettes->getid()]);
        }

        return $this->render('admin/ingredients/show.html.twig', [
            'recettes' => $recettes,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_articles_show", methods={"GET"})
     */
    public function showArticles(Articles $article): Response
    {
        return $this->render('admin/articles/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/users/{id}/edit", name="admin_users_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Users $user): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->remove('password');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setDateUpdate(new \DateTime());
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin_users_index', ['id'=>$user->getid()]);
        }

        return $this->render('admin/users/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/users/new", name="admin_users_new", methods={"GET","POST"})
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

            return $this->redirectToRoute('admin_users_index');
        }

        return $this->render('admin/users/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/recette/new", name="admin_recettes_new", methods={"GET","POST"})
     */
    public function newRecette(Request $request,SluggerInterface $slugger): Response
    {
        $recette = new Recettes();
        $form = $this->createForm(RecettesType::class, $recette);
        $form->remove('save');
        $form->remove('ingredients');
        $form->remove('preparations');
        $form->handleRequest($request);

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
            $entityManager->persist($recette);
            $entityManager->flush();

            return $this->redirectToRoute('admin_recettes_showtwo', ['id'=>$recette->getid()]);
        }

        return $this->render('admin/recettes/new.html.twig', [
            'recette' => $recette,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/new", name="articles_new", methods={"GET","POST"})
     */
    public function newArticles(Request $request): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('articles_index');
        }

        return $this->render('admin/articles/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/users/{id}/delete", name="admin_users_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Users $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_users_index');
    }


}
