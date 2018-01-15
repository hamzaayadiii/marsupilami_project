<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FoodRecord;
use AppBundle\Entity\User;
use AppBundle\Form\FoodType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Csrf\CsrfToken;

class AmisController extends Controller {

    /**
     * @Route("/", name="accueil")
     */
    public function indexAction() {
        return $this->render('accuiel/index.html.twig');
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
//dump($amis);die();
            $ami = $em->getRepository('AppBundle:User')->find($amis);
            $currentUserId = $this->get('security.token_storage')->getToken()->getUser()->getId();
            $currentUser = $em->getRepository('AppBundle:User')->find($currentUserId);
            $currentUser->addAmi($ami);
            $em = $this->getDoctrine()->getManager();
            $em->persist($currentUser);
            $em->flush();
        }

        $amis = $em->getRepository('AppBundle:User')->findAll();
        return $this->render('amis/index.html.twig', array(
                    'amis' => $amis,
                    'form' => $form->createView(),
        ));
    }

}
