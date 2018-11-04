<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoitureController extends Controller
{
    /**
     * @Route("/voitures", name="voiture_lists", methods={"GET"})
     *
     */
    public function getAllVoiture(Request $request) {

        $voitures = $this->get('doctrine.orm.entity_manager')
                        ->getRepository(Voiture::class)
                        ->findAll();

        $reponse = [];

        foreach ($voitures as $voiture){

            $reponse[] = [
                'id'        => $voiture->getId(),
              'marque'      => $voiture->getMarque(),
              'couleur'     => $voiture->getCouleur(),
              'type'        => $voiture->getType(),
              'puissance'   => $voiture->getPuissance(),
              'nombrePlace' => $voiture->getNombrePlace()
            ];


        }
        return new JsonResponse($reponse);
    }

    /**
     *
     * @Route("/voitures/{id}", name="voiture_one", methods={"GET"})
     */

    public function getVoitureByID(Request $request){

        $voiture = $this->get('doctrine.orm.entity_manager')
                        ->getRepository(Voiture::class)
                        ->find($request->get('id'));


        $reponse[] = [
            'id'        => $voiture->getId(),
            'marque'      => $voiture->getMarque(),
            'couleur'     => $voiture->getCouleur(),
            'type'        => $voiture->getType(),
            'puissance'   => $voiture->getPuissance(),
            'nombrePlace' => $voiture->getNombrePlace()
        ];

        return new JsonResponse($reponse);

    }

    /**
     * @Route("/new", name="voiture_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($voiture);
            $em->flush();

            return $this->redirectToRoute('voiture_index');
        }

        return $this->render('voiture/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="voiture_show", methods="GET")
     */
    public function show(Voiture $voiture): Response
    {
        return $this->render('voiture/show.html.twig', ['voiture' => $voiture]);
    }

    /**
     * @Route("/{id}/edit", name="voiture_edit", methods="GET|POST")
     */
    public function edit(Request $request, Voiture $voiture): Response
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('voiture_edit', ['id' => $voiture->getId()]);
        }

        return $this->render('voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="voiture_delete", methods="DELETE")
     */
    public function delete(Request $request, Voiture $voiture): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voiture->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($voiture);
            $em->flush();
        }

        return $this->redirectToRoute('voiture_index');
    }
}
