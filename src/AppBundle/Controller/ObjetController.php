<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\media;
use AppBundle\Entity\Objet;
use AppBundle\Entity\User;
use AppBundle\Form\MediaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Objet controller.
 *
 * @Route("user/objet")
 */
class ObjetController extends Controller
{
    /**
     * Lists all objet entities.
     *
     * @Route("/afficheobjet/{id}", name="afficheobjet")
     */
    public function afficheobjetAction(Request $request , Objet $objet)
    {
        $user = $this->getUser();


        //$em = $this->getDoctrine()->getManager();
        //$objets = $em->getRepository('AppBundle:Objet')->find($objet->getId());
        $contacdejaenvoyer=$this->getDoctrine()->getManager()->getRepository('AppBundle:Contact')->findAll();


        return $this->render('objet/showuneobjet.html.twig', array(
            'objet' => $objet,
            'contactdejaenvoyer'=>$contacdejaenvoyer,
            'user'=>$user,
        ));
    }


    /**
     * Lists all objet entities.
     *
     * @Route("/list_objet", name="listobjet_user")
     */
    public function listobjetuserAction()
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $objets = $em->getRepository('AppBundle:Objet')->findBy(['user'=>$user], array('date' => 'desc'));
        $contacdejaenvoyer=$this->getDoctrine()->getManager()->getRepository('AppBundle:Contact')->findAll();


        return $this->render(':objet:listobjetutilisateur.html.twig', array(
            'objets' => $objets,
            'contactdejaenvoyer'=>$contacdejaenvoyer,
            'user'=>$user,
        ));
    }


    /**
     * Creates a new objet entity.
     *
     * @Route("/perdue", name="objet_newperdue")
     */
    public function newperdueAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $objet = new Objet();
        $form = $this->createForm('AppBundle\Form\ObjetperdueType', $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cat=$request->get('categorie');
            $categorie=$em->getRepository('AppBundle:Categorie')->find($cat);
            $objet->setCategorie($categorie);
            $objet->setUser($user);
            $objet->setType('perdue');
            $em->persist($objet);
            $em->flush();

            return $this->redirectToRoute('list_objettouver', array('id' => $objet->getId()));
        }

        $categorie = $em->getRepository('AppBundle:Categorie')->findAll();
        $contacdejaenvoyer=$this->getDoctrine()->getManager()->getRepository('AppBundle:Contact')->findAll();


        return $this->render(':objet:newperdue.html.twig', array(
            'objet' => $objet,
            'form' => $form->createView(),
            'user'=>$user,
            'contactdejaenvoyer'=>$contacdejaenvoyer,
            'categorie'=>$categorie,
        ));
    }


    /**
     * Creates a new objet entity.
     *
     * @Route("/trouver", name="objet_newtrouver")
     */
    public function newtrouverAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $objet = new Objet();
        $form = $this->createForm('AppBundle\Form\ObjettrouverType', $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $cat=$request->get('categorie');

            $categorie=$em->getRepository('AppBundle:Categorie')->find($cat);
            $objet->setCategorie($categorie);
            $objet->setUser($user);
            $objet->setType('trouver');
            $em->persist($objet);
            $em->flush();

            return $this->redirectToRoute('list_objetperdue', array('id' => $objet->getId()));
        }

        $categorie = $em->getRepository('AppBundle:Categorie')->findAll();
        $contacdejaenvoyer=$this->getDoctrine()->getManager()->getRepository('AppBundle:Contact')->findAll();


        return $this->render(':objet:newtouver.html.twig', array(
            'objet' => $objet,
            'form' => $form->createView(),
            'user'=>$user,
            'contactdejaenvoyer'=>$contacdejaenvoyer,
            'categorie'=>$categorie,
        ));
    }

    /**
    * Lists all objet entities.
    *
    * @Route("/listobjettrouver/{id}", name="list_objettouver")
    */
    public function listobjettrouverAction(Request $request , Objet $object)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        //testrole
        if (($object->getUser() != $user) ){
            return $this->redirectToRoute("listobjet_user");
        }
        //endtest

        $categorie=$object->getCategorie();
        $adresse = $object->getGouvernorat();

        $query = $this->getDoctrine()->getManager()
            ->createQuery("SELECT u FROM AppBundle:objet u WHERE (u.user <> :role AND u.type='trouver' and u.categorie = :categorie and u.gouvernorat = :adresse  )"
            )->setParameter('role', $user )->setParameter('categorie', $categorie )->setParameter('adresse', $adresse );
        $objetusertrouver_matching100 = $query->getResult();

        $query = $this->getDoctrine()->getManager()
            ->createQuery("SELECT u FROM AppBundle:objet u WHERE (u.user <> :role AND u.type='trouver' and u.categorie = :categorie and u.gouvernorat <> :adresse )"
            )->setParameter('role', $user )->setParameter('categorie', $categorie )->setParameter('adresse', $adresse );
        $objetusertrouver_matching50 = $query->getResult();

        $contacdejaenvoyer=$this->getDoctrine()->getManager()->getRepository('AppBundle:Contact')->findAll();


        return $this->render(':objet:listobjettrouver.html.twig', array(
            'objets_100' => $objetusertrouver_matching100,
            'objets_50' => $objetusertrouver_matching50,
            'objectevoyer'=>$object,
            'contactdejaenvoyer'=>$contacdejaenvoyer,
            'user'=>$user,
        ));
    }


    /**
     * Lists all objet entities.
     *
     * @Route("/listobjetperdue/{id}", name="list_objetperdue")
     */
    public function listobjetperdueAction(Request $request , Objet $object)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        //testrole
        if (($object->getUser() != $user) ){
            return $this->redirectToRoute("listobjet_user");
        }
        //endtest

        $categorie=$object->getCategorie();

        $adresse = $object->getGouvernorat();

        $query = $this->getDoctrine()->getManager()
            ->createQuery("SELECT u FROM AppBundle:objet u WHERE (u.user <> :role AND u.type='perdue' and u.categorie = :categorie and u.gouvernorat = :adresse  )"
            )->setParameter('role', $user )->setParameter('categorie', $categorie )->setParameter('adresse', $adresse );
        $objetusertrouver_matching100 = $query->getResult();

        $query = $this->getDoctrine()->getManager()
            ->createQuery("SELECT u FROM AppBundle:objet u WHERE (u.user <> :role AND u.type='perdue' and u.categorie = :categorie and u.gouvernorat <> :adresse )"
            )->setParameter('role', $user )->setParameter('categorie', $categorie )->setParameter('adresse', $adresse );
        $objetusertrouver_matching50 = $query->getResult();

        $contacdejaenvoyer=$this->getDoctrine()->getManager()->getRepository('AppBundle:Contact')->findAll();

        return $this->render(':objet:listobjetperdue.html.twig', array(
            'objets_100' => $objetusertrouver_matching100,
            'objets_50' => $objetusertrouver_matching50,
            'user'=>$user,
            'objectevoyer'=>$object,
            'contactdejaenvoyer'=>$contacdejaenvoyer,
        ));
    }





    /**
     * Displays a form to edit an existing objet entity.
     *
     * @Route("/{type}/{id}/edit", name="objet_edit")
     */
    public function editAction(Request $request, Objet $objet)
    {

        $user=$this->getUser();
        //testrole
        if (($objet->getUser() != $user) ){
            return $this->redirectToRoute("listobjet_user");
        }
        //endtest

        if ($request->get('type') == 'perdue'){
            $editForm = $this->createForm('AppBundle\Form\ObjetperdueType', $objet);
        }else{
            $editForm = $this->createForm('AppBundle\Form\ObjettrouvereditType', $objet);
        }
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $cat=$request->get('categorie');
            $categorie=$this->getDoctrine()->getManager()->getRepository('AppBundle:Categorie')->find($cat);
            $objet->setCategorie($categorie);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('objet_edit', array('type'=>$objet->getType(),'id' => $objet->getId()));
        }

        $categorie=$this->getDoctrine()->getManager()->getRepository('AppBundle:Categorie')->findAll();
        $contacdejaenvoyer=$this->getDoctrine()->getManager()->getRepository('AppBundle:Contact')->findAll();




        return $this->render('objet/edit.html.twig', array(
            'user'=>$user,
            'objet' => $objet,
            'contactdejaenvoyer'=>$contacdejaenvoyer,
            'form' => $editForm->createView(),
            'categorie' =>$categorie,
        ));
    }

    /**
     * Deletes a objet entity.
     *
     * @Route("/supprimer_objet/{id}", name="supprimer_objet")
     * @Method("POST")
     */
    public function supprimerobjetAction(Request $request, Objet $objet)
    {
            $user = $this->getUser();
            //testrole
            if (($objet->getUser() != $user) ){
                return $this->redirectToRoute("listobjet_user");
            }
            //endtest
            $em = $this->getDoctrine()->getManager();

            $ob1 = $em->getRepository('AppBundle:Contact')->findBy(['objetreceive'=>$objet]);
            $ob2 = $em->getRepository('AppBundle:Contact')->findBy(['objetenvoyer'=>$objet]);
            if($ob1 != '' ){
                foreach ($ob1 as $product) {
                    $em->remove($product);
                }
            }
            if($ob2 == '') {
                foreach ($ob2 as $product) {
                    $em->remove($product);
                }
            }

            if ($objet->getImages() != ''){
                $em->remove($objet->getImages());
            }
            if ($objet->getImage2() != ''){
                $em->remove($objet->getImage2());
            }
            if ($objet->getImage3() != ''){
                $em->remove($objet->getImage3());
            }

                $em->remove($objet);
                $em->flush();

        return $this->redirectToRoute('listobjet_user');
    }

    /* */

    /**
     * Deletes a objet entity.
     *
     * @Route("/objetperdue_contact/{idreceive}/{objetenvoyer}/{objetreceive}/{type}", name="contacter")
     */
    public function objetperdueAction(Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $userenvoyer=$this->getUser();
        $userreceive=$em->getRepository('AppBundle:User')->find($request->get('idreceive'));
        $objetenvoyer=$em->getRepository('AppBundle:Objet')->find($request->get('objetenvoyer'));
        $objetreceive=$em->getRepository('AppBundle:Objet')->find($request->get('objetreceive'));


        $user = $this->getUser();
        //testrole
        if (($objetenvoyer->getUser() != $user) ){
            return $this->redirectToRoute("listobjet_user");
        }
        //endtest

        $em = $this->getDoctrine()->getManager();





        $contact = new Contact();
        $contact->setUserenvoyer($userenvoyer);
        $contact->setUserreceive($userreceive);
        $contact->setObjetenvoyer($objetenvoyer);
        $contact->setObjetreceive($objetreceive);


        $em->persist($contact);
        $em->flush();

        if ($request->get('type')=='listperdue') {
            return $this->redirectToRoute('list_objetperdue', array('id' => $objetenvoyer->getId()));
        }
        else{

            return $this->redirectToRoute('list_objettouver', array('id' => $objetenvoyer->getId()));

        }
    }


    /**
     * Deletes a objet entity.
     *
     * @Route("/supprimer_invitation/{id}", name="supprimer_invitation")
     */
    public function supprimerinvitationobjetAction(Request $request, Contact $contact)
    {
        $user = $this->getUser();
        //testrole
        if (($contact->getUserreceive() != $user) ){
            return $this->redirectToRoute("listobjet_user");
        }
        //endtest

        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();

        return $this->redirect($request->server->get('HTTP_REFERER'));

    }


    /**
     * Deletes a objet entity.
     *
     * @Route("/objetperdue_contact/{idreceive}/{objetenvoyer}/{objetreceive}", name="annuler_invibuttonlist")
     */
    public function annulerinvibuttonlistAction(Request $request )
    {


        $em = $this->getDoctrine()->getManager();
        $userreceive = $em->getRepository('AppBundle:User')->find($request->get('idreceive'));
        $objetenvoyer = $em->getRepository('AppBundle:Objet')->find($request->get('objetenvoyer'));
        $objetreceive = $em->getRepository('AppBundle:Objet')->find($request->get('objetreceive'));


        $suppconatact = $em->getRepository('AppBundle:Contact')->findOneBy(['userreceive' => $userreceive, 'objetenvoyer' => $objetenvoyer, 'objetreceive' => $objetreceive]);

            $em->remove($suppconatact);
            $em->flush();



        return $this->redirect($request->server->get('HTTP_REFERER'));

    }


}
