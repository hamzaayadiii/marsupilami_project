<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FoodRecord;
use AppBundle\Entity\User;
use AppBundle\Form\FoodType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AmisController extends Controller {

    /**
     * @Route("/", name="accueil")
     */
    public function indexAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('AppBundle\Form\amisType', null);
        if ($request->isMethod('POST')) {
            $amis = $request->request->get('amis')["amis"];
            $ami = $em->getRepository('AppBundle:User')->find($amis);
            $currentUserId = $this->get('security.token_storage')->getToken()->getUser()->getId();
            $currentUser = $em->getRepository('AppBundle:User')->find($currentUserId);
            $currentUser->addAmi($ami);
            $em = $this->getDoctrine()->getManager();
            $em->persist($currentUser);
            $em->flush();
        }
        return $this->render('accuiel/index.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/amis/ajouter", name="amis_ajouter")
     */
    public function ajouteramisAction() {
        return $this->render('amis/add.html.twig');
    }

    /**
     * @Route("/amis", name="amis_index")
     */
    public function amisAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('AppBundle\Form\amisType', null);
        if ($request->isMethod('POST')) {
            $amis = $request->request->get('amis')["amis"];
            $ami = $em->getRepository('AppBundle:User')->find($amis);
            $currentUserId = $this->get('security.token_storage')->getToken()->getUser()->getId();
            $currentUser = $em->getRepository('AppBundle:User')->find($currentUserId);
            $currentUser->addAmi($ami);
            $em = $this->getDoctrine()->getManager();
            $em->persist($currentUser);
            $em->flush();
        }


        return $this->render('amis/index.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/retirer", name="amis_retirer")
     */
    public function retireramisAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('GET')) {
            $currentUserId = $this->get('security.token_storage')->getToken()->getUser()->getId();
            $currentUser = $em->getRepository('AppBundle:User')->find($currentUserId);
            $IdAmi = $request->query->get('id');
            $ami = $em->getRepository('AppBundle:User')->find($IdAmi);
            if ($ami)
                $currentUser->removeAmi($ami);
            $em = $this->getDoctrine()->getManager();
            $em->persist($currentUser);
            $em->flush();
            return $this->redirectToRoute('accueil');
        }
    }

    /**
     *
     * @Route("/api/ami", name="api_amis" ,options = { "expose" = true })
     * @Method("GET")
     */
    public function ApiListeAmisAction(Request $request) {
        $utilisateur = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($utilisateur) {
                $em = $this->getDoctrine()->getManager();

             //   return new JsonResponse($utilisateur->getId());
 $utilisateur = $em->getRepository('AppBundle:User')->listeAmis($utilisateur->getId());
        }
        return new JsonResponse(array(
            'message' => "Liste chargé avec success.",
            'utilisateur' => $utilisateur,
          
                ), Response::HTTP_OK
        );
    }


    /**
     *
     * @Route("/api/utilisateur", name="api_utilisateurs" ,options = { "expose" = true })
     * @Method("GET")
     */
    public function ApiListeUtilisateursAction(Request $request) {
        $utilisateur = $this->container->get('security.token_storage')->getToken()->getUser();
        if ($utilisateur) {
                $em = $this->getDoctrine()->getManager();
                $utilisateurs = $em->getRepository('AppBundle:User')->liste();
        }
        return new JsonResponse(array(
            'message' => "Liste chargé avec success.",
            'utilisateurs' => $utilisateurs,
          
                ), Response::HTTP_OK
        );
    }

     /**
     *
     * @Route("/api/ajouter", name="api_ajouter_ami")
     * @Method({"POST"})
     */
    public function apiAjouterAmiAction(Request $request) {
      
        $em = $this->getDoctrine()->getManager();
//        $form = $this->createForm('AppBundle\Form\UserType', $users);
  //      $form->handleRequest($request);
            $body = $request->getContent();
            $data = json_decode($body, true);
            $amis = $data['nouveauAmi'];
            $ami = $em->getRepository('AppBundle:User')->find($amis);
            $currentUserId = $this->get('security.token_storage')->getToken()->getUser()->getId();
            $currentUser = $em->getRepository('AppBundle:User')->find($currentUserId);
            $currentUser->addAmi($ami);
            $em = $this->getDoctrine()->getManager();
            $em->persist($currentUser);
            $em->flush();


            return new JsonResponse(array(
                'message' => "Ami ajouté avec success")
                    , Response::HTTP_OK
            );
        
     
    }


    /**
     *
     * @Route("/api/retirer", name="api_retirer_ami")
     * @Method({"POST"})
     */
    public function apiRetirerAmiAction(Request $request) {
      
        $em = $this->getDoctrine()->getManager();
            $body = $request->getContent();
            $data = json_decode($body, true);
            $amis = $data['id'];
            $ami = $em->getRepository('AppBundle:User')->find($amis);
            $currentUserId = $this->get('security.token_storage')->getToken()->getUser()->getId();
            $currentUser = $em->getRepository('AppBundle:User')->find($currentUserId);
            $currentUser->removeAmi($ami);
            $em = $this->getDoctrine()->getManager();
            $em->persist($currentUser);
            $em->flush();
            return new JsonResponse(array(
                'message' => "Ami retirer avec success")
                    , Response::HTTP_OK
            );
        
     
    }

}
