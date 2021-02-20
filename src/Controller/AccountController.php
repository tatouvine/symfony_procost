<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    public function __construct()
    {

    }

    /**
     * @Route("/mom-compte/first-page", name="first_page")
     */
    public function firstPage(): Response
    {
        return $this->render('pagePersonnel.html.twig', [
            "numeroPage" => 1
        ]);
    }

    /**
     * @Route("/mom-compte/second-page", name="second_page")
     */
    public function secondPage(): Response
    {
        return $this->render('pagePersonnel.html.twig', [
            "numeroPage" => 2
        ]);
    }
}
