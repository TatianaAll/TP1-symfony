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

    //je fais ma méthode getArticle en lui donnant une route
    #[Route('/articles', name: 'articles')]
    public function getArticles()
    {
        return $this->render('articles.html.twig', ['articles' => $this->articles]);
    }

    // je fais une méthode pour filtrer mes articles par ID
    #[Route('/article', name: 'article_show')]
    public function showArticle()
    {
        $this->getArticles();

        // j'initie un articleFound à null
        $articleFound = null;

        // je vais récupérer mes commande de server, donc notamment mes entrées en GET
        // pour ça j'utilise la class Request et la methode createFromGlobals
        $request = Request::createFromGlobals();
        //ici je stocke dans une variable id la valeur GET récupérée par createFromGlobals
        // et je prend spécifiquement la valeur pour la clé 'id'
        $id = $request->query->get('id');

        // je parcours mes articles récupérés
        foreach ($this->articles as $article) {
            // si l'id de mon article correspond à l'id stocké depuis le get
            if ($article['id'] === (int)$id) {
                //alors je donne à mon articleFound les données de mon article avec le meme id
                $articleFound = $article;
                return $this->render('article_show.html.twig', ['article' => $article]);
            }
        } return $this->render('error_404.html.twig');
    }
}