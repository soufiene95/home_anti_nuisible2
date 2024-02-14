<?php
namespace App\Controller;



use DateTime;
use App\Entity\Calendar;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    #[Route('/api', name: 'app_api')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
    
    #[Route('/api/{id}/edit', name: 'app_api_event_edit', methods:['PUT'])]
    public function majEvent(?Calendar $calendar, Request $request): Response
    {
        // récupérer données
        $donnees = json_decode($request->getContent());

        if (
            isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->description) && !empty($donnees->description) && // Correction de la faute de frappe ici
            isset($donnees->backgroundColor) && !empty($donnees->backgroundColor) &&
            isset($donnees->borderColor) && !empty($donnees->borderColor) &&
            isset($donnees->textColor) && !empty($donnees->textColor)
        ) {
            // données sont complètes
            // initialise un code
            $code = 200;

            // on vérifie si l'id existe
            if (!$calendar) {
                // instancie un rdv
                $calendar = new Calendar;

                // change le code
                $code = 201;
            }

            // hydrate l'objet avec les données
            $calendar->setTitle($donnees->title);
            $calendar->setDescription($donnees->description);
            $calendar->setStart(new DateTime($donnees->start));
            if ($donnees->allDay) {
                $calendar->setEnd(new DateTime($donnees->start));
            } else {
                $calendar->setEnd(new DateTime($donnees->end));
            }
            $calendar->setAllDay($donnees->allDay);
            $calendar->setBackgroundColor($donnees->backgroundColor);
            $calendar->setBorderColor($donnees->borderColor);
            $calendar->setTextColor($donnees->textColor);

            $this->em->persist($calendar);
            $this->em->flush();

            // $em = $this->getDoctrine()->getManager();
            // $em->persist($calendar);
            // $em->flush();

            //retourne le code
            return new Response('Ok', $code);
        } else {
            // données sont incomplètes
            return new Response('Données incomplètes', 404);
        }

        

        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }
}
