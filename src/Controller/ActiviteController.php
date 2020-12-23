<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Participant;
use App\Form\ActiviteGroupeType;
use App\Form\ActiviteGroupeEditType;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;
use App\Utilities\GestionMedia;
use App\Utilities\Utility;
use Cocur\Slugify\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/backend/activite")
 *
 * @IsGranted("ROLE_USER")
 */
class ActiviteController extends AbstractController
{
    private $gestionMedia;
    private $utility;

    public function __construct(GestionMedia $gestionMedia, Utility $utility)
    {
        $this->gestionMedia = $gestionMedia;
        $this->utility = $utility;
    }

    /**
     * @Route("/", name="backend_activite_index", methods={"GET"})
     */
    public function index(ActiviteRepository $activiteRepository): Response
    {
        // récupération du groupe de l'utilisateur
        $user = $this->getUser();

        // Si l'utilisateur est un chef de groupe
        if ($user->getRoles()[0] === "ROLE_USER"){
            $activityList = $activiteRepository->findBy(['groupe'=>$user->getGroupe()],['dateDebut'=>"DESC"]);
        }elseif ($user->getRoles()[0] === "ROLE_DISTRICT"){

        }elseif ($user->getRoles()[0] === "ROLE_REGION"){

        }else{
            $activityList = $activiteRepository->findBy([],['dateDebut'=>"DESC"]);
        }

        //dd($activityList);
        $i = 0; $activites = [];
        foreach ($activityList as $item){
            $participants = count($this->getDoctrine()->getRepository(Participant::class)->findBy(['activite'=>$item->getId()]));
            $activites[$i] = [
                'id' => $item->getId(),
                'type' => $item->getType(),
                'nom' => $item->getNom(),
                'dateDebut' => $item->getDateDebut(),
                'dateFin' => $item->getDateFin(),
                'lieu' => $item->getLieu(),
                'situation' => $item->getSituation(),
                'description' => $item->getDescription(),
                'latittude' => $item->getLatittude(),
                'longetude' => $item->getLongetude(),
                'nomProprietaire' => $item->getNomProprietaire(),
                'fonctionProprietaire' => $item->getFonctionProprietaire(),
                'contactProprietaire' => $item->getContactProprietaire(),
                'autorisation' => $item->getAutorisation(),
                'niveau' => $this->utility->niveau($item->getNiveau()),
                'createdAt' => $item->getCreatedAt(),
                'updatedAt' => $item->getUpdatedAt(),
                'groupe' => $item->getGroupe(),
                'annee' => $item->getAnnee(),
                'slug' => $item->getSlug(),
                'participants' => $participants
            ];

            $i++;
        }

        if (!$activites){
            $activites = $activiteRepository->findBy(['groupe'=>$user->getGroupe()],['dateDebut'=>"DESC"]);
        }

        return $this->render('activite/index.html.twig', [
            'activites' => $activites,
        ]);
    }

    /**
     * @Route("/new", name="backend_activite_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $activite = new Activite();

        // Verification du type de user
        $user = $this->getUser();

        if ($user->getRoles()[0] === "ROLE_USER"){
            $form = $this->createForm(ActiviteGroupeType::class, $activite);
        }else{
            $form = $this->createForm(ActiviteType::class, $activite);
        }


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // Gestion du fichier media
            $mediaFile = $form->get('autorisation')->getData();

            if ($mediaFile){
                $media = $this->gestionMedia->upload($mediaFile, 'autorisation');

                $activite->setAutorisation($media);
            }

            // Gestion du groupe
            if ($user->getRoles()[0] === 'ROLE_USER'){
                $activite->setGroupe($user->getGroupe());
            }

            // année scout du camp
            $activite->setAnnee($this->utility->annee());
            //dd($activite);

            // Slug
            $slugify = new Slugify();
            $slug_string = $activite->getNom().'-'.time();
            $slug = $slugify->slugify($slug_string);
            $activite->setSlug($slug);

            $entityManager->persist($activite);
            $entityManager->flush();

            $this->addFlash('success', "Votre activité a bien été enregistrée. Veuillez ajouter les participants à présent");

            return $this->redirectToRoute('backend_activite_index');
        }

        return $this->render('activite/new.html.twig', [
            'activite' => $activite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="backend_activite_show", methods={"GET"})
     */
    public function show(Activite $activite): Response
    {
        $participants = $this->getDoctrine()->getRepository(Participant::class)->findBy(['activite'=>$activite->getId()]);
        //dd($participants);
        $cible = $this->utility->niveau($activite->getNiveau());
        return $this->render('activite/show.html.twig', [
            'activite' => $activite,
            'participants' => $participants,
            'cible' => $cible
        ]);
    }

    /**
     * @Route("/{slug}/edit", name="backend_activite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Activite $activite): Response
    {

        // Verification du type de user
        $user = $this->getUser();

        if ($user->getRoles()[0] === "ROLE_USER"){
            $form = $this->createForm(ActiviteGroupeEditType::class, $activite);
        }else{
            $form = $this->createForm(ActiviteType::class, $activite);
        }

        //$form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "L'activité a été modifiée avec succès");

            return $this->redirectToRoute('backend_activite_index');
        }

        return $this->render('activite/edit.html.twig', [
            'activite' => $activite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="backend_activite_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Activite $activite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($activite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('backend_activite_index');
    }
}
