<?php

namespace App\Controller;

use App\Entity\Prestations;
use App\Form\PrestationsType;
use App\Repository\PrestationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/prestations')]
class PrestationsController extends AbstractController
{
    #[Route('/', name: 'app_prestations_index', methods: ['GET'])]
    public function index(PrestationsRepository $prestationsRepository): Response
    {
        return $this->render('prestations/index.html.twig', [
            'prestations' => $prestationsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_prestations_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $prestation = new Prestations();
        $form = $this->createForm(PrestationsType::class, $prestation);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();
            /*
                S'il n'y a pas de chargement de fichier, $imageFile = null
                S'il y a un chargement de fichier, $imageFile retourne un objet de la class UploadedFile

            */

            if ($imageFile) {
                // 1e - Définir le nom du fichier
                $nomImage = date('YmdHis') . '-' . uniqid() . '.' . $imageFile->getClientOriginalExtension();

                // 2e - Enregistrer le fichier dans le dossier public sous le nom crée avant
                $imageFile->move(
                    $this->getParameter('prestation'),
                    $nomImage
                );

                // 3e - Enregistrer le nom du fichier dans l'objet en bdd
                $prestation->setImage($nomImage);
            }



            $entityManager->persist($prestation);
            $entityManager->flush();

            return $this->redirectToRoute('app_prestations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prestations/new.html.twig', [
            'prestation' => $prestation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prestations_show', methods: ['GET'])]
    public function show(Prestations $prestation): Response
    {
        return $this->render('prestations/show.html.twig', [
            'prestation' => $prestation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_prestations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Prestations $prestation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PrestationsType::class, $prestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();
            /*
                S'il n'y a pas de chargement de fichier, $imageFile = null
                S'il y a un chargement de fichier, $imageFile retourne un objet de la class UploadedFile

            */

            if ($imageFile) {
                // 1e - Définir le nom du fichier
                $nomImage = date('YmdHis') . '-' . uniqid() . '.' . $imageFile->getClientOriginalExtension();

                // 2e - Enregistrer le fichier dans le dossier public sous le nom crée avant
                $imageFile->move(
                    $this->getParameter('prestation'),
                    $nomImage
                );

                if($prestation->getImage()){
                    unlink($this->getParameter('prestation') . '/' . $prestation->getImage());
                    // public/image/prestation/blabla.png
                }

                // 3e - Enregistrer le nom du fichier dans l'objet en bdd
                $prestation->setImage($nomImage);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_prestations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('prestations/edit.html.twig', [
            'prestation' => $prestation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_prestations_delete', methods: ['POST'])]
    public function delete(Request $request, Prestations $prestation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$prestation->getId(), $request->request->get('_token'))) {
            if($prestation->getImage()){
                unlink($this->getParameter('prestation') . '/' . $prestation->getImage());
            }

            $entityManager->remove($prestation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_prestations_index', [], Response::HTTP_SEE_OTHER);
    }
}
