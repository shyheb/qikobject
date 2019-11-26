<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))
           return  $this->redirectToRoute('admin');

        $contacdejaenvoyer=$this->getDoctrine()->getManager()->getRepository('AppBundle:Contact')->findAll();
        return $this->render(':default:index.html.twig',array('user'=>$user,'contactdejaenvoyer'=>$contacdejaenvoyer,));
    }

}
