<?php
// namespace sert à organiser et structurer le code en regroupant les classes selon leurs fonctions
//ça agit comme un chemin virtuel pour identifier les classes dans un projet
namespace App\Controller;

// j'appelle les fichiers de symfony que j'utilise sur cette page donc :
// le fichier de la class Response qui va nous retourner du html proprement
use Symfony\Component\HttpFoundation\Response;

// le fichier de la class Route qui nous permet de faire le routing de nos page
use Symfony\Component\Routing\Attribute\Route;

// je déclare ma class HomeController
class HomeController
{
// avec l'annotation Route ça me permet de donner le chemin avec '/' --> je vais rediriger l'URL suivi de rien
// à l'URL /home
    #[Route('/', name: 'home')]
    // Je créer la méthode home qui me retourne une instance de la classe Response
    public function home(): Response
    {
        // je retourne une instance avec un h1 de ma page d'accueil
        return new Response('<h1>Ma page d\'accueil</h1>', 200);
    }

}