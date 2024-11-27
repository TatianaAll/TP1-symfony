<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
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

}