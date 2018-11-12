<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use Doctrine\DBAL\Schema\View;
use PhpParser\Node\Expr\Cast\String_;
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

        if(empty($voitures)){
        return new JsonResponse(['Message' => 'Aucune voiture enregistre pour le moment'], Response::HTTP_NOT_FOUND);

        }

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
        return new JsonResponse($reponse,Response::HTTP_OK, []);
    }

    /**
     *
     * @Route("/voitures/{id}", name="voiture_one", methods={"GET"})
     */

    public function getVoitureByID(Request $request){

        $voiture = $this->get('doctrine.orm.entity_manager')
                        ->getRepository(Voiture::class)
                        ->find($request->get('id'));

        if (empty($voiture)){

            return new JsonResponse(["Message" =>  "Voiture non trouvé"],Response::HTTP_NOT_FOUND);
        }

        $reponse[] = [
            'id'        => $voiture->getId(),
            'marque'      => $voiture->getMarque(),
            'couleur'     => $voiture->getCouleur(),
            'type'        => $voiture->getType(),
            'puissance'   => $voiture->getPuissance(),
            'nombrePlace' => $voiture->getNombrePlace()
        ];

        return new JsonResponse($reponse,Response::HTTP_OK, []);

    }

    /**
     * @Route("/new_voiture", name="voiture_new", methods="POST")
     */
    public function addVoitureAction(Request $request)
    {
       $voiture = new Voiture();

       $voiture -> setMarque($request->query->  get('marque'))
                           -> setType          ($request->query->  get('type'))
                           -> setCouleur       ($request->query->  get('couleur'))
                           -> setPuissance     ($request->query->  get('puissance'))
                           -> setNombrePlace   ($request->query->  get('nombre_place'))
                ;

       $em = $this->getDoctrine()-> getManager();
       $em-> persist($voiture);
       $em-> flush();

        $this->redirectToRoute('voiture_lists',Response::HTTP_CREATED);

    }

 

    /**
     * @Route("/voiture_update/{id}", name="voiture_edit", methods="PUT")
     */
    public function updateVoitureAction(Request $request, Voiture $voiture)
    {
        $body = $request->getContent();

        $data = json_decode($body,true);

        $form = $this->createForm(VoitureType::class, $voiture);

        $form->submit($data);

        $validator = $this->get('validator');

        $errors = $validator->validate($voiture);

        if (count($errors) > 0){

            $errorString = (string) $errors;

            return new JsonResponse($errorString,Response::HTTP_NOT_MODIFIED);
        }

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->redirectToRoute('voiture_lists',Response::HTTP_OK);
    }

    /**
     * @Route("/voiture/{id}", name="voiture_delete", methods="DELETE")
     */
    public function deleteAction(Request $request, Voiture $voiture)
    {
        if ($this->isCsrfTokenValid('delete'.$voiture->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($voiture);
            $em->flush();
        }

     return   $this->redirectToRoute('voiture_lists');
    }
}
