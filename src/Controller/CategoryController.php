<?php

// Entité Category créé à partir du terminal grace à : php bin/console make:entity
// création automatique de mon entité Category et de son repo
//le repo ne permet que des faire des SELECT et pas de modifier avec des INSERT ou quoi
//  Ensuite je fais php bin/console make:migration qui permet de faire la migration
// ca crée une version dans migrations
// pour finir j'envoie ça dans ma BDD avec php bin/console make:migration:migrate

// j'ai ensuite ajouté des données manuellement dans ma BDD via phpmyadmin

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

//j'aurai besoin que ma class hérite de AbstractController pour utiliser la methode render
class CategoryController extends AbstractController
{
    //je définie la route pour afficher toutes mes categories

    #[Route(path :'/categories', name: 'categories')]
    //je fais un autowire de category repo pour pouvoir questionner ma BDD
    public function showAllCategories(CategoryRepository $categoryRepository) : Response
    {
        //je vérifie ma route
//        dump("coucou");die;

        //je crée une variable categories qui vaut toutes les catégories trouvé dans ma BDD avec toutes les colonnes
        $categories = $categoryRepository->findAll();
        //je retourne le rendu visuel en appelant ma vue et en lui donnant l'objet catégorie stocké dans ma variable éponyme
        return $this->render('categories.html.twig', ['categories' => $categories]);

    }

    //ma nouvelle route pour mes categories selon leurs id
    //je l'oblige à avoir un id et que l'id soit un integer (en regex)
    #[Route(path: '/category/{id}', name:'category_show', requirements:['id' => '\d+'])]
    //nouvelle méthode avec un autowire de CategoryRepo et un id qui sera un integer
    public function getCategoryById(CategoryRepository $categoryRepository, int $id) : Response
    {
        // j'initie un articleFound à null
        $categoryFound = $categoryRepository->find($id);

        //si je ne trouve pas de categorie
        if ($categoryFound === null) {
            //je redirige vers une 404
            return $this->redirectToRoute('error_404.html.twig');
        } return $this->render('category_show.html.twig', ['category' => $categoryFound]);
        //sinon je renvoie ma page twig en lui donnant ma categorie trouvé précédement
    }

    #[Route(path:'/category/create', name: 'category_create')]
    //j'autowire mon EntityManager pour faire une sauvegarde dans ma BDD
    public function createCategory(EntityManagerInterface $entityManager,
    Request $request) : Response
    {
        //je crée une nouvelle instance de l'entité Category
        $category = new Category();

        //je fais ma logique avec la création de form automatique
        //pour la création de mon formulaire je donne à la méthode createForm (héritée d'AbstractController)
        //1- le chemin de mon gabarit de forumaire donc CategoryType crée avec php bin/console make:form
        //2- l'instance de l'entité Category nouvellement créé
       $form= $this->createForm(CategoryType::class, $category);

       //je fais la view que je vais renvoyer à mon twig pour la création en HTML du formulaire
       $formView = $form->createView();

       //je vais compléter mon forumlaire avec les données envoyé en requete post
        $form->handleRequest($request);
        //si mon formulaire à bien été soumis je vais enreristrer et pousser dans ma DataBase
        if ($form->isSubmitted()) {
            $entityManager->persist($category);
            $entityManager->flush();
        }

        return $this->render('category_create.html.twig', ['formView' => $formView]);

    }

    #[Route(path:'/category/delete/{id}', name: 'category_delete', requirements: ['id'=>'\d+'])]
    public function deleteCategory(int $id,
                                   EntityManagerInterface $entityManager,
                                   CategoryRepository $categoryRepository) : Response
    {
        //dd("test");
        $categoryToDelete = $categoryRepository->find($id);
        //si on trouve pas on redirige vers une page d'erreur
        if (!$categoryToDelete) {
            return $this->redirectToRoute('not_found');
        }
        $entityManager->remove($categoryToDelete);
        $entityManager->flush();
        return $this->render('category_delete.html.twig', ['category' => $categoryToDelete]);
    }

    #[Route(path:'/category/update/{id}', name: 'category_update', requirements: ['id'=>'\d+'])]
    public function updateCategory(int $id,
                                   EntityManagerInterface $entityManager,
                                   CategoryRepository $categoryRepository,
                                    Request $request) : Response
    {
        //on cherche l'instance de Catégorie qui répond à l'id renseigné
        $categoryToUpdate = $categoryRepository->find($id);
        $methodPost = false;
        //si elle n'exsite pas c'est un 404
        if (!$categoryToUpdate) {
            return $this->redirectToRoute('not_found');
        }
        if($request->isMethod('POST')){
            $methodPost = true;
            //on récupère les données rentrées par le user
            $newCategoryTitle = $request->request->get('title');
            $newCategoryColor = $request->request->get('color');

            //on changes les infos de notre catégorie
            $categoryToUpdate->setTitle($newCategoryTitle);
            $categoryToUpdate->setColor($newCategoryColor);

            //on enregistre les changements en local
            $entityManager->persist($categoryToUpdate);
            //on envoie les changement à la DB
            $entityManager->flush();
        }


        // on retourne une jolie page qui dit que c'est bon
        return $this->render('category_update.html.twig', ['category' => $categoryToUpdate, 'methodPost' => $methodPost]);
    }


}