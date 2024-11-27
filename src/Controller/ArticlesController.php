<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticlesController extends AbstractController
{
    //je met mes article dans une propriété
    #[Route('/articles', name: 'articles')]
    public function getArticles(): Response
    {
        $articles = [
            [
                'id' => 1,
                'title' => 'Article 1',
                'content' => 'Content of article 1',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 2,
                'title' => 'Article 2',
                'content' => 'Content of article 2',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 3,
                'title' => 'Article 3',
                'content' => 'Content of article 3',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 4,
                'title' => 'Article 4',
                'content' => 'Content of article 4',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 5,
                'title' => 'Article 5',
                'content' => 'Content of article 5',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ]
        ];
        return $this->render('articles.html.twig', ['articles' => $articles]);
    }

    #[Route('/article/{id}', 'article_show', ['id' => '\d+'])]
    public function showArticle(int $id): Response
    {
        //je recupere mes articles
        $articles = [
            [
                'id' => 1,
                'title' => 'Article 1',
                'content' => 'Content of article 1',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 2,
                'title' => 'Article 2',
                'content' => 'Content of article 2',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 3,
                'title' => 'Article 3',
                'content' => 'Content of article 3',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 4,
                'title' => 'Article 4',
                'content' => 'Content of article 4',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ],
            [
                'id' => 5,
                'title' => 'Article 5',
                'content' => 'Content of article 5',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
                'createdAt' => new \DateTime('2030-01-01 00:00:00')
            ]
        ];

        // j'initie un articleFound à null
        $articleFound = null;

        // je parcours mes articles récupérés
        foreach ($articles as $article) {
            // si l'id de mon article correspond à l'id stocké depuis le get
            if ($article['id'] === $id) {
                //alors je donne à mon articleFound les données de mon article avec le meme id
                $articleFound = $article;
            }
            //si je n'ai rien qui correspond je renvoie une page d'erreur
        }
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