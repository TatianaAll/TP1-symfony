<?php
// namespace sert à organiser et structurer le code en regroupant les classes selon leurs fonctions
//ça agit comme un chemin virtuel pour identifier les classes dans un projet
namespace App\Controller;

// j'appelle les fichiers de symfony que j'utilise sur cette page donc :
// le fichier de la class Response qui va nous retourner du html proprement
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;

// le fichier de la class Route qui nous permet de faire le routing de nos page
use Symfony\Component\Routing\Attribute\Route;

// je déclare ma class HomeController
class HomeController extends AbstractController
{
// avec l'annotation Route ça me permet de donner le chemin avec '/' --> je vais rediriger l'URL suivi de rien
// à l'URL /home
    #[Route('/', name: 'home')]
    // Je créer la méthode home qui me retourne une instance de la classe Response
    public function home(): Response
    {
        // je retourne la valeur de cette méthode dans ma view twig
        return $this->render('base.html.twig');
    }

    #[Route('search_results', name: 'search_results')]
    //on a besoin de la requete GET
        // et d'une instance de CategoryRepo pour la methode search
    public function searches(CategoryRepository $categoryRepository,ArticleRepository $articleRepository, Request $request)
    {
        //dd("coucou");
        //on récupère notre requete GET donc la fin de notre URL
        $search = $request->query->get('search');
        //dd($search);
        //on définies les catégories trouvées avec la méthode searchCategories de CategoryRepo
        $categoriesFound = $categoryRepository->searchCategories($search);
        $articlesFound = $articleRepository->search($search);
        //dd($categoriesFound);

        return $this->render('search_result.html.twig',
            ['categoriesFound'=>$categoriesFound,
            'articlesFound'=> $articlesFound,
            'search'=>$search]);
    }

}