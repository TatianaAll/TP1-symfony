<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

//je créé une nouvelle classe qui hérite de AbstractController
//comme ça je pourrais appeler les render depuis cette nouvelle classe
class ContactController extends AbstractController
{
    //je défini la route de ma nouvelle méthode
    #[Route(path : '/contact_form', name: 'contactForm')]
    public function showContactForm(Request $request)
    {
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $subject = $request->request->get('subject');
        $message_area = $request->request->get('message_area');

        //j'affiche mon formulaire de contact
        return $this->render('contact_form.html.twig',['name'=>$name, 'email'=>$email, 'subject'=>$subject,
                'message_area'=>$message_area]);
    }

}

