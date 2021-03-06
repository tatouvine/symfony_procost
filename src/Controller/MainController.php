<?php

namespace App\Controller;

use App\Entity\Src\Contact;
use App\Form\ContactType;
use App\Manager\ContactManager;
use App\Repository\Src\Store\ProductRepository;
use App\Service\ContactMailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private ContactManager $contactManager;
    private ProductRepository $productRepository;

    public function __construct(ContactManager $contactManager, ProductRepository $productRepository)
    {
        $this->contactManager = $contactManager;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/", name="main_homepage")
     */
    public function index(): Response
    {
        $lastProducts = $this->productRepository->findByTimeFourLastProduct();
        $popularProducts = $this->productRepository->findByFourProductHaveLotOfComment();
        return $this->render('main/index.html.twig', [
            'lastProducts' => $lastProducts,
            'popularProducts' => $popularProducts
        ]);
    }

    /**
     * @Route("/presentation", name="main_presentation")
     */
    public function presentation(): Response
    {
        return $this->render('main_presentation.html.twig');
    }

    /**
     * @Route("/contact", name="main_contact",methods={"GET","POST"})
     */
    public function contact(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        // Demande au formulaire d'interpréter la Request
        $form->handleRequest($request);

        // Dans le cas de la soumission d'un formulaire valide
        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactManager->save($contact);
            // Action à effectuer aprés envoie du formulaire

            return $this->redirectToRoute('main_contact');
        }

        return $this->render('main_contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
