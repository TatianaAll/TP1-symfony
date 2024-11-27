<?php

// Entité Category créé à partir du terminal grace à : php bin/console make:entity
// création automatique de mon entité Category et de son repo
//  Ensuite je fais php bin/console make:migration qui permet de faire la migration
// ca crée une version dans migrations
// pour finir j'envoie ça dans ma BDD avec php bin/console make:migration:migrate

// j'ai ensuite ajouté des données manuellement dans ma BDD via phpmyadmin

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

//j'aurai besoin que ma class hérite de AbstractController pour utiliser la methode render
class CategoryController extends AbstractController
{
    //je définie la route pour afficher toutes mes categories

    #[Route(path :'/categories', name: 'categories')]
    //je fais un autowire de category repo pour pouvoir questionner ma BDD
    public function showAllCategories(CategoryRepository $categoryRepository)
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
    public function getCategoryById(CategoryRepository $categoryRepository, int $id)
    {
        // j'initie un articleFound à null
        $categoryFound = $categoryRepository->find($id);

        if ($categoryFound === null) {
            return $this->redirectToRoute('error_404.html.twig');
        } return $this->render('category_show.html.twig', ['category' => $categoryFound]);
    }
}