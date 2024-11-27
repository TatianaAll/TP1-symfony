<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ErrorController extends AbstractController
{
    #[Route('/not-found', 'not_found')]
    public function notFound(){
        // pour créer une réponse personnalisée avec une erreur 404
        $view = $this->renderView('error_404.html.twig');
        //ici je vais pouvoir préciser que je veux le status 404 pour cette page
        return new Response($view, 404);
    }
}