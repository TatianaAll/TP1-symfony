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
    //pour ma route je précise une URL avec une variable ID
    //quand je demanderais mon URL avec /article/2 j'aurai l'article correspondant à article 2
    //quand je demanderais un URL avec /article/5 je devrait avoir l'article 5 etc.
    #[Route('/article/{id}', name: 'article_show')]
    //vu que j'ai une variable dans mon URL je suis obligée de demander cette variable en parametre de ma methode
    // j'ajoute donc un parametre id
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
}