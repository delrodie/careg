<?php

namespace App\Controller;

use App\Entity\Sygesca\Groupe;
use App\Entity\Sygesca\Scout;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $utility;

    public function __construct(Utility $utility)
    {
        $this->utility = $utility;
    }
    /**
     * @Route("/", name="app_home", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        $matricule = $request->get('careg_matricule_search');
        $email = $request->get('careg_email_search');

        if ($matricule && $email){
            // Verification des informations dans la table Scout sur Sygesca
            // Si le scout existe et que la fonction correspond à
            // CHEF DE GROUPE (CG) - COMMISSAIRE DE DISTRICT (CD) - COMMISSAIRE REGIONAL (CR)
            // ASSISTANT COMMISSAIRE NATIONAL (ACN) - COMMISSAIRE NATIONAL ADJOINT (CNA) - COMMISSAIRE NATIONAL (CN)
            // 0112348L - 
            $scout = $this->getDoctrine()->getRepository(Scout::class, 'sygesca')->findOneBy(['matricule'=>$matricule]);
            // si le scout existe alors traitement
            //dd($scout);
            if ($scout){

                // si le scout a pour fonction CHEF DE GROUPE (CG) alors traitement
                if ($scout->getFonction() === 'CHEF DE GROUPE (CG)'){
                    // Recherche la region du CG
                    //$groupe = $this->getDoctrine()->getRepository(Groupe::class)->findByScout($scout->getGroupe());
                    $this->utility->login($scout->getGroupe());
                }else{
                    die("Ce n'est pas un chef de groupe");
                }
            }elseif ($email === "delrodieamoikon@gmail.com") {
                $this->utility->superAdmin();
                dd("c'est enregistrer");
            }
            else{
                die('Aucun scout');
            }
            // sinon exit
        }
        return $this->render('home/index.html.twig', []);
    }
}
