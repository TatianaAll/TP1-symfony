<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ErrorController extends AbstractController
{
    #[Route('/not-found', 'not-found')]
    public function notFound(){
        // pour créer une réponse personnalisée avec une erreur 404
        $view = $this->renderView('error_404.html.twig');
        //
        return new Response($view, 404);
    }
}