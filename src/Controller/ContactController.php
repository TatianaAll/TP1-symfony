<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

//je créé une nouvelle classe qui hérite de AbstractController
//comme ça je pourrais appeler les render depuis cette nouvelle classe
class ContactController extends AbstractController
{
    //je définie la route de ma nouvelle méthode
    #[Route('/contact_form', 'contactForm')]
    public function showContactForm()
    {
        return $this->render('contact_form.html.twig');
    }

    #[Route('/contact_submit', 'contactSubmit')]
    public function getContactForm(Request $request)
    {

        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $subject = $request->request->get('subject');
        $message_area = $request->request->get('message_area');


        return $this->render('contact_submit.html.twig',
            ['name'=>$name, 'email'=>$email, 'subject'=>$subject,
                'message_area'=>$message_area]);
//        if ($email && $subject && $message_area) {
//
//        } else return $this->redirectToRoute('not_found');



    }
}

