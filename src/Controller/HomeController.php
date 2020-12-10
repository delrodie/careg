<?php

namespace App\Controller;

use App\Entity\Sygesca\Groupe;
use App\Entity\Sygesca\Scout;
use App\Utilities\Utility;
use phpDocumentor\Reflection\Types\This;
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
            $scout = $this->getDoctrine()->getRepository(Scout::class, 'sygesca')->findOneBy(['matricule'=>$matricule, 'cotisation'=>$this->utility->annee()]);
            // si le scout existe alors traitement
            //dd($scout);
            if ($scout){

                // si le scout a pour fonction CHEF DE GROUPE (CG) alors traitement
                if ($scout->getFonction() === 'CHEF DE GROUPE (CG)'){
                    $parametres = $this->utility->registration($scout->getGroupe(), $email, 'CG');
                    if (!$parametres) {
                        $this->addFlash('danger', "ECHEC! votre groupe a déjà été enregistré. Si vous pensez que c'est une erreur veuillez contacter l'equipe nationale");
                        return $this->redirectToRoute('app_home');
                    }
                    else {
                        $this->addFlash('success', "SUCCES! Le compte de votre groupe a été crée avec succès. Veuillez copier et garder soignemesement les paramètres de connexion ci-dessous");
                        $this->addFlash('success', "&nbsp; Login : <strong> &nbsp;" . $parametres['username']."</strong>");
                        $this->addFlash('success', "&nbsp; Mot de passe : <strong> &nbsp;" . $parametres['password']."</strong>");

                        return $this->redirectToRoute('app_home');
                    }
                }elseif ($scout->getFonction() === 'COMMISSAIRE DE DISTRICT (CD)'){
                    $parametres = $this->utility->registration($scout->getGroupe(), $email, 'CD');
                    if (!$parametres) {
                        $this->addFlash('danger', "ECHEC! votre district a déjà été enregistré. Si vous pensez que c'est une erreur veuillez contacter l'equipe nationale");
                        return $this->redirectToRoute('app_home');
                    }
                    else {
                        $this->addFlash('success', "SUCCES! Le compte de votre district a été crée avec succès. Veuillez copier et garder soignemesement les paramètres de connexion ci-dessous");
                        $this->addFlash('success', "&nbsp; Login : <strong> &nbsp;" . $parametres['username']."</strong>");
                        $this->addFlash('success', "&nbsp; Mot de passe : <strong> &nbsp;" . $parametres['password']."</strong>");

                        return $this->redirectToRoute('app_home');
                    }
                }elseif ($scout->getFonction() === 'COMMISSAIRE REGIONAL (CR)'){
                    $parametres = $this->utility->registration($scout->getGroupe(), $email, 'CR');
                    if (!$parametres) {
                        $this->addFlash('danger', "ECHEC! votre région a déjà été enregistrée. Si vous pensez que c'est une erreur veuillez contacter l'equipe nationale");
                        return $this->redirectToRoute('app_home');
                    }
                    else {
                        $this->addFlash('success', "SUCCES! Le compte de votre région a été crée avec succès. Veuillez copier et garder soignemesement les paramètres de connexion ci-dessous");
                        $this->addFlash('success', "&nbsp; Login : <strong> &nbsp;" . $parametres['username']."</strong>");
                        $this->addFlash('success', "&nbsp; Mot de passe : <strong> &nbsp;" . $parametres['password']."</strong>");

                        return $this->redirectToRoute('app_home');
                    }
                }elseif ($scout->getFonction() === 'ASSISTANT COMMISSAIRE NATIONAL (ACN)' || $scout->getFonction() === 'COMMISSAIRE NATIONAL ADJOINT (CNA)'){
                    $parametres = $this->utility->registration($scout->getGroupe(), $email, 'NATIONAL');
                    if (!$parametres) {
                        $this->addFlash('danger', "ECHEC! votre compte a déjà été enregistré. Si vous pensez que c'est une erreur veuillez contacter le departement PIT");
                        return $this->redirectToRoute('app_home');
                    }
                    else {
                        $this->addFlash('success', "SUCCES! Votre compte a été crée avec succès. Veuillez copier et garder soignemesement les paramètres de connexion ci-dessous");
                        $this->addFlash('success', "&nbsp; Login : <strong> &nbsp;" . $parametres['username']."</strong>");
                        $this->addFlash('success', "&nbsp; Mot de passe : <strong> &nbsp;" . $parametres['password']."</strong>");

                        return $this->redirectToRoute('app_home');
                    }
                }elseif ($scout->getFonction() === 'COMMISSAIRE NATIONAL (CN)' || $scout->getFonction() === 'COMMISSAIRE NATIONAL' ){
                    $parametres = $this->utility->registration($scout->getGroupe(), $email, 'CN');
                    if (!$parametres) {
                        $this->addFlash('danger', "ECHEC! votre compte a déjà été enregistré. Si vous pensez que c'est une erreur veuillez contacter le departement PIT");
                        return $this->redirectToRoute('app_home');
                    }
                    else {
                        $this->addFlash('success', "SUCCES! Votre compte a été crée avec succès. Veuillez copier et garder soignemesement les paramètres de connexion ci-dessous");
                        $this->addFlash('success', "&nbsp; Login : <strong> &nbsp;" . $parametres['username']."</strong>");
                        $this->addFlash('success', "&nbsp; Mot de passe : <strong> &nbsp;" . $parametres['password']."</strong>");

                        return $this->redirectToRoute('app_home');
                    }
                }
                else{
                    $this->addFlash('danger', "Vous n'êtes pas autorisé(e) à avoir un compte.");
                    return $this->redirectToRoute('app_home');
                }
            }elseif ($email === "delrodieamoikon@gmail.com") {
                $superAdmin = $this->utility->superAdmin();
                if (!$superAdmin) {
                    $this->addFlash('danger', "Vous êtes déjà inscrit");
                    return  $this->redirectToRoute('app_home');
                }else{
                    $this->addFlash('success', "Soyez la bienvenue Delrodie AMOIKON");
                }
            }
            else{
                $this->addFlash('danger', "Votre matricule n'existe pas ou vous ne vous êtes pas encore acquitté(e) de la cotisation de cette année");
                return $this->redirectToRoute('app_home');
            }
            // sinon exit
        }
        return $this->render('home/index.html.twig', []);
    }
}
