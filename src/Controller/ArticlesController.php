<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticlesController extends AbstractController
{
    //je met mes article dans une propriété
    public array $articles = [
        [
            'id' => 1,
            'title' => 'Article 1',
            'content' => 'Content of article 1',
            'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
        ],
        [
            'id' => 2,
            'title' => 'Article 2',
            'content' => 'Content of article 2',
            'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
        ],
        [
            'id' => 3,
            'title' => 'Article 3',
            'content' => 'Content of article 3',
            'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
        ],
        [
            'id' => 4,
            'title' => 'Article 4',
            'content' => 'Content of article 4',
            'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
        ],
        [
            'id' => 5,
            'title' => 'Article 5',
            'content' => 'Content of article 5',
            'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
        ]

    ];

    #[Route('/articles', name: 'articles')]
    public function getArticles()
    {
        return $this->render('articles.html.twig', ['articles' => $this->articles]);
    }

    #[Route('/article/{id}', name: 'article_show')]
    public function showArticle($id)
    {
        //je recupere mes articles
        $this->getArticles();

        // j'initie un articleFound à null
        $articleFound = null;

        // je parcours mes articles récupérés
        foreach ($this->articles as $article) {
            // si l'id de mon article correspond à l'id stocké depuis le get
            if ($article['id'] === (int)$id) {
                //alors je donne à mon articleFound les données de mon article avec le meme id
                $articleFound = $article;
                return $this->render('article_show.html.twig', ['article' => $article]);
            }
            //si je n'ai rien qui correspond je renvoie une page d'erreur
        } return $this->render('error_404.html.twig');
    }

    //on va faire une nouvelle page pour filtrer par categorie : 1- routing
    #[Route('/articles/search_results', name: 'articles_search_result')]
    // j'utilise dans ma methode un autowire
    //je vais donc lui passer en parametre $request en précisant avec le typage que
    //$request est une instance de la class Request
    //symfony va m'autocomplété tout pour me faire cette instance de classe sans que j'ai besoin
    // de préciser les parametres du constructeur
    public function searchArticle(Request $request){

        $search = $request->query->get('search');

        dump($search); die;
    }
}