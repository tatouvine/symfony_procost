<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="main_contact")
     */
    public function contact(): Response
    {
        $url = $this->generateUrl('main_contact', []);
        return $this->render('main_contact.html.twig',
        [
            'url'=>$url
        ]);
    }
}