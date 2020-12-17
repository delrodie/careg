<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Participant;
use App\Entity\Sygesca\Region;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @Route("/backend/dashboard")
 */
class DashboardController extends AbstractController
{
    private $utility;

    public function __construct(Utility $utility)
    {
        $this->utility = $utility;
    }
    /**
     * @Route("/", name="backend_dashboard_index")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $activitesRepository = $this->getDoctrine()->getRepository(Activite::class);
        $participantRepository = $this->getDoctrine()->getRepository(Participant::class);

        if (($user->getRoles()[0]==='ROLE_NATIONAL') || ($user->getRoles()[0]==="ROLE_SUPER_ADMIN") || ($user->getRoles()[0]=== "ROLE_ADMIN")){
            $activites = $activitesRepository->findBy(['annee'=>$this->utility->annee()]);
            $activiteList = $activitesRepository->findEncours();
            $activites_encours=[]; $i = 0;
            foreach ($activiteList as $item){
                $nb_participant = count($participantRepository->findBy(['activite'=>$item->getId()]));
                $activites_encours[$i]= [
                    'id' => $item->getId(),
                    'type' => $item->getType(),
                    'nom' => $item->getNom(),
                    'dateDebut' => $item->getDateDebut(),
                    'dateFin' => $item->getDateFin(),
                    'lieu' => $item->getLieu(),
                    'niveau' => $this->utility->niveau($item->getNiveau()),
                    'groupe' => $item->getGroupe(),
                    'annee' => $item->getAnnee(),
                    'slug' => $item->getSlug(),
                    'participants' => $nb_participant,
                    'region' => $item->getGroupe()->getDistrict()->getRegion(),
                    'district' => $item->getGroupe()->getDistrict(),
                ];
                $i++;
            }

            // Nombre d'activités par region
            $regionID = [1,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18]; $j=0; $nb_activites_region = [];
            foreach ($regionID as $item){
                $nb_activites_region[$j] = [
                    'initial' => $this->utility->initial_region($item)[0],
                    'nom' => $this->utility->initial_region($item)[1],
                    'couleur' => $this->utility->initial_region($item)[2],
                    'nombre' => count($activitesRepository->findByRegion($item)),
                    'participant' => count($participantRepository->findByRegion($item))
                ];
                $j++;
            } //dd(count($participantRepository->findByRegion(5)));

        }elseif($user->getRoles()[0]==="ROLE_REGION"){
            $activites = $activitesRepository->findAll();
        }elseif($user->getRoles()[0]==='ROLE_DISTRICT'){
            $activites = $activitesRepository->findAll();
        }else{
            $activites = $activitesRepository->findAll();
        }

        // Statistiques
        $nombre_activite = count($activites);
        if ($nombre_activite === 0) $nombre_activite = 1;
        foreach ($activites as $item){
            $nombre = count($participantRepository->findAll());
            $total_participant = $nombre++;
        }
        $moyenne_participant = $total_participant / $nombre_activite;

        return $this->render('dashboard/index.html.twig', [
            'activites' => $activites,
            'moyenne_participant' => $moyenne_participant,
            'activites_encours' => $activites_encours,
            'regions' => $nb_activites_region
        ]);
    }
}
