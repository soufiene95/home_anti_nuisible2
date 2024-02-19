<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Service\SendEmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact_index', methods: ['GET','POST'])]
    public function index(Request $request, EntityManagerInterface $em, SendEmailService $sendEmailService): Response
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em->persist($contact);
            $em->flush();

            $sendEmailService->send([
                "sender_email" => "homeantinuisible@gmail.com",
                "sender_name" => "Abdenour Maali",
                "recipient_email" => "homeantinuisible@gmail.com",
                "subject" => "Un message réçu dans votre tableau de bord",
                "html_template" => "emails/contact.html.twig",
                "context" => [
                    "contact_first_name" => $contact->getFirstName(),
                    "contact_last_name" => $contact->getLastName(),
                    "contact_email" => $contact->getEmail(),
                    "contact_phone" => $contact->getPhone(),
                    "contact_message" => $contact->getMessage(),
                ]
            ]);

            $this->addFlash("success", "Votre message à bien été envoyé. Nous vous contacterons dans les plus brefs délais.");

            return $this->redirectToRoute("app_contact_index");
        }

        return $this->render('contact/index.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/show', name: 'app_contact_show', methods:['GET', 'POST'])]
    public function show(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();

        return $this->render('contact/show.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    #[Route('/show/{id<\d+>}/delete', name: 'app_contact_delete', methods: ['DELETE','POST'])]
    public function delete(Contact $contact, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete_contact_'.$contact->getId(), $request->request->get('csrf_token'))) 
        {
            $em->remove($contact);
            $em->flush();

            $this->addFlash('success', "Ce message à bien été supprimé.");
        }

        return $this->redirectToRoute('app_contact_show');
    }
    // #[Route('/new', name: 'app_contact_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $contact = new Contact();
    //     $form = $this->createForm(ContactType::class, $contact);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($contact);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('contact/new.html.twig', [
    //         'contact' => $contact,
    //         'form' => $form,
    //     ]);
    // }

    // 

    // #[Route('/{id}/edit', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(ContactType::class, $contact);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('contact/edit.html.twig', [
    //         'contact' => $contact,
    //         'form' => $form,
    //     ]);
    // }

    // 
    //     return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    // }
}
