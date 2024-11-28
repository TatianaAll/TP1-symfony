<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticlesController extends AbstractController
{
    //je met mes article dans une propriété
    #[Route('/articles', name: 'articles')]
    public function getArticles(ArticleRepository $articleRepository): Response
    {
        $articles=$articleRepository->findAll();
        return $this->render('articles.html.twig', ['articles' => $articles]);
    }

    #[Route('/article/{id}', 'article_show', ['id' => '\d+'])]
    public function showArticle(int $id, ArticleRepository $articleRepository): Response
    {

        // j'initie un articleFound à null
        $articleFound = $articleRepository->find($id);

        if ($articleFound === null) {
            return $this->redirectToRoute('error_404.html.twig');
        } return $this->render('article_show.html.twig', ['article' => $articleFound]);
    }

    //on va faire une nouvelle page pour filtrer par categorie : 1- routing
    #[Route('/articles/search_results', name: 'articles_search_result')]
    // j'utilise dans ma methode un autowire
        //je vais donc lui passer en parametre $request en précisant avec le typage que
        //$request est une instance de la class Request
        //symfony va m'autocompléter tout pour me faire cette instance de classe sans que j'ai besoin
        // de préciser les parametres du constructeur
    public function searchArticle(Request $request): Response
    {

        //ma variable search contient les informations de get de la requete HTTP
        $search = $request->query->get('search');
        //je retourne cette variable dans la page twig associée
        return $this->render('articles_search_result.html.twig', ['search' => $search]);

    }

    #[Route(path:'/article/create', name:'article_create')]
    public function createArticle(EntityManagerInterface $entityManager): Response{
        //dd("coucou");

        //créer un article
        //en faisant une nouvelle instance de l'entité Article
        $article = new Article();

        //Puis on rempli notre nouvel article avec les méthodes set de la classe Article
        $article->setTitle('Un article fait à la mains');
        $article->setContent('Un article de qualité, créé à la main, moulé dans un moule et sorti tout chaud du four de Symfony');
        $article->setCreatedAt(new \DateTime());
        $article->setImage('https://labonneflambee.fr/49-large_default/four-a-tarte-flambee-et-pizza-le-wackes.jpg');
        //on vérifie que ça fonctionne bien
        //dd($article);

        //une fois notre instance créée, l'ORM pourra faire correspondre cette instance avec le SQL
        //utilisation de EntityManagerInterface
        //on ''''''commit'''''', on envoie nos modif
        $entityManager->persist($article);
        //puis on '''push''' donc on envoie à notre BDD le nouvel article
        $entityManager->flush();

        return $this->render('article_create.html.twig', ['article' => $article]);
    }

    //je fais ma route pour ma suppression d'article, je donne un id en URL en m'assurant que c'est un integer avec une regex
    #[Route (path:'/article/delete/{id}', name: 'article_delete', requirements: ['id'=>'\d+'])]
    //je doit avoir un id
    //j'appelle une instance de mon Article Repo car je vais avoir besoin de parcourir toutes mes instances de l'entité Article qui sont créée
   //j'appelle une instance d'EntityManager pour pouvoir modifier ma BDD
    public function deleteArticle(int $id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager): Response
    {
        //dd("coucou");
        //on va chercher l'article avec l'ID qui matche notre recherche
        $articleToDelete = $articleRepository->find($id);

        //si on trouve pas on redirige vers une page d'erreur
        if (!$articleToDelete) {
            return $this->redirectToRoute('not_found');
        }

        //dd($articleToDelete);
        //On retire en local notre article
        $entityManager->remove($articleToDelete);
        //on envoie l'info de la suppression à la DB
        $entityManager->flush();
        
        return $this->render('article_delete.html.twig', ['article' => $articleToDelete]);
    }

}