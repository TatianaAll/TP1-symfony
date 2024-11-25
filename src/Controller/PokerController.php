<?php
//je défini le name space
namespace App\Controller;

//j'appelle les classes Symfony que je vais utiliser
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

//je déclare ma class PokerController
class PokerController
{
    // je définie la route avec l'URL qui est suivi de /poker
    //je lui donne le nom "poker"
    #[Route('/poker', name: 'poker')]
    public function poker(){
        //appel de la methode createFromGloblal de la class Request
        // sans avoir besoin d'instancier une nouvelle class Request
        //et ça grace au double points ::
        //la class Request avec sa method createFromGlobals permet de stocker
        //les infos en POST, GET,
        $request = Request::createFromGlobals();
        //je récupère ma variable age à partir des infos du get de mon URL
        $age = $request->query->get('age');
        //je les affiche avec un var_dum et je tue mon process
        if($age < 18){
            return new Response('<h1>Ma page d\'accueil</h1> <p>Vous n\'avez pas l\'âge requis</p>');
        } else {
            return new Response('<h1>Ma page d\'accueil</h1> <p>Bienvennue sur POKER WORD THE MOST FAMOUS POKER WEBSITE !</p>');
        }
    }
}