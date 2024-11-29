<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use DateTime;
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
        $articles = $articleRepository->findAll();
        return $this->render('articles.html.twig', ['articles' => $articles]);
    }

    #[Route('/article/{id}', 'article_show', ['id' => '\d+'])]
    public function showArticle(int $id, ArticleRepository $articleRepository): Response
    {

        // j'initie un articleFound à null
        $articleFound = $articleRepository->find($id);

        if ($articleFound === null) {
            return $this->redirectToRoute('error_404.html.twig');
        }
        return $this->render('article_show.html.twig', ['article' => $articleFound]);
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

    #[Route(path: '/article/create', name: 'article_create')]
    public function createArticle(EntityManagerInterface $entityManager, Request $request): Response
    {
        //créer un article
        //en faisant une nouvelle instance de l'entité Article
        $article = new Article();

        //avec l'exécution de la ligne de commande "php bin/console make:form",
        //on a nommé ce form ArticleType
        //et il est valide pour l'entité Article (form crée dans le fichier éponyme dans src)

        //je crée ici un formulaire correspondant à ce qui est renseigné dans ArticleType (donc les champs à compléter)
        //et ça grace à la methode createForm d'AbstractArticle (dont ArticleController hérite)

        //createForm est une méthode qui demande des paramètres ==>(string $type, mixed $data = null, array $options = [])
        //le type est le chemin jusqu'à mon "constructeur" de formulaire, je pourrais aussi écrire app\Form\ArticleType (le namespace)
        //et en second paramètre je donne l'instance de l'entité Article sur laquelle je vais travailler
        $form = $this->createForm(ArticleType::class, $article);

        //il faut maintenant relier le form avec la requete post lié au formulaire
        //pour le formulaire généré on récupère les données de la requete réalisé
        $form->handleRequest($request);

        //est-ce que le formulaire a été envoyé pour ce formulaire ?
        if($form->isSubmitted()) {
            //j'ai symfony qui rempli mes champs grace a handleRequest
            //mais j'ai retiré le champs input de la date de création, donc il faut que je la remplisse automatiquement
            $article->setCreatedAt(new DateTime());
            //si oui alors je sauvegarde mon article et je l'envoie à la DB
            $entityManager->persist($article);
            $entityManager->flush();
        }
        //je génère une view du formulaire créé précédemment
        $formView = $form->createView();

        //si j'ai pas de demande je renvoi juste mon nouvel article vide
        return $this->render('article_create.html.twig', ['formView'=>$formView]);
    }


    //je fais ma route pour ma suppression d'article, je donne un id en URL en m'assurant que c'est un integer avec une regex
    #[Route (path: '/article/delete/{id}', name: 'article_delete', requirements: ['id' => '\d+'])]
    //je doit avoir un id
        //j'appelle une instance de mon Article Repo car je vais avoir besoin de parcourir toutes mes instances de l'entité Article qui sont créée
        //j'appelle une instance d'EntityManager pour pouvoir modifier ma BDD
    public function deleteArticle(int $id,
                                  ArticleRepository $articleRepository,
                                  EntityManagerInterface $entityManager): Response
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

    #[Route(path: '/article/update/{id}', name: 'article_update', requirements: ['id' => '\d+'])]
    function updateArticle(int $id,
                           EntityManagerInterface $entityManager,
                           ArticleRepository $articleRepository,
                           Request $request): Response
    {
        //dd("coucou");

        //je récupère l'article qui correspond à mon ID rentré
        $articleToUpdate = $articleRepository->find($id);

        //pour mon affichage twig je crée une variable
        $postRequest = false;

        //s'il n'existe pas on renvoie vers une 404
        if (!$articleToUpdate) {
            return $this->redirectToRoute('not_found');
        }

        //si j'ai ma un submit
        if($request->isMethod('POST')) {
            $newTitle = $request->request->get('title');
            $newContent = $request->request->get('content');
            $newImage = $request->request->get('image');

            $articleToUpdate->setTitle($newTitle);
            $articleToUpdate->setContent($newContent);
            $articleToUpdate->setImage($newImage);

            $postRequest = true;

            //on va donc faire persister notre instance d'Article modifié
            $entityManager->persist($articleToUpdate);
            //puis on va sauvegarder les modifs en DB
            $entityManager->flush();

        }
        //j'envoie à mon twig les valeurs précédentes pour les charger en value dans mes inputs
        //j'envoie aussi mon postRequest pour l'affichage de mon form ou non
        return $this->render('article_update.html.twig', ['article' => $articleToUpdate, 'postRequest' => $postRequest]);
    }

}