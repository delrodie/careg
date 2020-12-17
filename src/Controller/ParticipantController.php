<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Participant;
use App\Entity\Sygesca\Scout;
use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use App\Utilities\Utility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backend/participant")
 */
class ParticipantController extends AbstractController
{
    private $utility;

    public function __construct(Utility $utility)
    {
        $this->utility = $utility;
    }
    /**
     * @Route("/", name="backend_participant_index", methods={"GET"})
     */
    public function index(ParticipantRepository $participantRepository): Response
    {
        return $this->render('participant/index.html.twig', [
            'participants' => $participantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{slug}/new", name="backend_participant_new", methods={"GET","POST"})
     */
    public function new(Request $request, Activite $activite): Response
    {
        $user = $this->getUser();

        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // recherche du scout  1837479M
            $scout = $this->getDoctrine()->getRepository(Scout::class, 'sygesca')->findOneBy([
                'matricule'=>$participant->getMatricule(),
                'cotisation'=>$this->utility->annee()
            ]);

            if (!$scout) {
                $this->addFlash('danger', "Ce scout n'existe pas ou ne s'est pas encore acquitté de sa cotisation nationale");
            }else{
                $verifExist = $this->getDoctrine()->getRepository(Participant::class)->findOneBy([
                    'matricule'=>$participant->getMatricule(),
                    'activite' => $activite->getId()
                ]);
                if ($verifExist) {
                    $this->addFlash('danger', "Ce scout a déjà été ajouté à cette activité");
                    return $this->redirectToRoute('backend_participant_new',['slug'=>$activite->getSlug()]);
                }
                $participant->setActivite($activite);
                $this->utility->participation($participant, $scout, $user->getUsername());

                $this->addFlash('success', "Le scout a été ajouté avec succès");
            }

            return $this->redirectToRoute('backend_participant_new',['slug'=>$activite->getSlug()]);
        }

        $participants = $this->getDoctrine()->getRepository(Participant::class)->findBy(['activite'=>$activite->getId()], ['id'=>'DESC']);

        return $this->render('participant/new.html.twig', [
            'participant' => $participant,
            'form' => $form->createView(),
            'activite' => $activite,
            'participants' => $participants
        ]);
    }

    /**
     * @Route("/{id}", name="backend_participant_show", methods={"GET"})
     */
    public function show(Participant $participant): Response
    {
        return $this->render('participant/show.html.twig', [
            'participant' => $participant,
        ]);
    }

    /**
     * @Route("/{id}/edit/", name="backend_participant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Participant $participant): Response
    {
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_participant_index');
        }

        return $this->render('participant/edit.html.twig', [
            'participant' => $participant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_participant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Participant $participant): Response
    {
        // sauvegarde de l'activité
        $activite = $participant->getActivite(); //dd($activite->getSlug());

        if ($this->isCsrfTokenValid('delete'.$participant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($participant);
            $entityManager->flush();

            $this->addFlash('success', 'Le scout a été supprimé avec succès de la liste des participants');
        }

        return $this->redirectToRoute('backend_participant_new', ['slug'=>$activite->getSlug()]);
    }
}
