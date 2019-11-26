<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminControllerController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function indexAction()
    {
        $user = $this->getUser();

        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        $catgories = $this->getDoctrine()->getRepository('AppBundle:Categorie')->findBy(['parant'=>null]);
        $objets = $this->getDoctrine()->getRepository('AppBundle:Objet')->findAll();
        $contact = $this->getDoctrine()->getRepository('AppBundle:Contact')->findAll();


        return $this->render(':admin:index.html.twig',array('user'=>$user,'users'=>$users,'categories'=>$catgories,'objets'=>$objets,'contact'=>$contact));
    }

    /**
     * @Route("/admin/gererCategorie", name="gererCategorie")
     */
    public function gerecategoriesAction()
    {
        $user = $this->getUser();
        $cat=$this->getDoctrine()->getManager()->getRepository('AppBundle:Categorie')->findAll();
        $souscat=$this->getDoctrine()->getManager()->getRepository('AppBundle:Categorie')->findAll();

        return $this->render(':admin:gerercategorie.html.twig',array('user'=>$user,'categories'=>$cat,'souscategories'=>$souscat));
    }

    /**
     * @Route("/admin/gereruser", name="gererUser")
     */
    public function gereuserAction()
    {
        $user = $this->getUser();
        $query = $this->getDoctrine()->getManager()
            ->createQuery("SELECT u FROM AppBundle:user u WHERE (u.roles like '%ROLE_USERQO%' )");
        $users = $query->getResult();

        return $this->render(':admin:gereruser.html.twig',array('user'=>$user,'users'=>$users));
    }

    /**
     * Deletes a objet entity.
     *
     * @Route("/supprimer_user/{id}", name="supprimer_user")
     */
    public function supprimeruserAction(Request $request, User $user)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirect($request->server->get('HTTP_REFERER'));

    }

    /**
     * Deletes a objet entity.
     *
     * @Route("/supprimer_categories/{id}", name="supprimer_categories")
     */
    public function supprimercategorisAction(Request $request, Categorie $categorie)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();

        return $this->redirect($request->server->get('HTTP_REFERER'));

    }






}
