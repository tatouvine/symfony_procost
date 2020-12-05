<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_homepage")
     */
    public function index(): Response
    {
        $url = $this->generateUrl('main_homepage', []);
        return $this->render('main/index.html.twig',
            [
                'url'=>$url
            ]);
    }

    /**
     * @Route("/presentation", name="main_presentation")
     */
    public function presentation(): Response
    {
        $url = $this->generateUrl('main_presentation', []);
        return $this->render('main_presentation.html.twig',
        [
        'url'=>$url
        ]);
    }
}