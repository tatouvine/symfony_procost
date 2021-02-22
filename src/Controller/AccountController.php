<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AccountController extends AbstractController
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @Route("/mom-compte/first-page", name="first_page")
     */
    public function firstPage(): Response
    {
        if ($this->isGranted('ROLE_USER') === true || $this->isGranted('ROLE_ADMIN') === true) {
            return $this->render('pagePersonnel.html.twig', [
                "numeroPage" => 1
            ]);
        } else {
            return new RedirectResponse($this->router->generate('security_login'));
        }

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
