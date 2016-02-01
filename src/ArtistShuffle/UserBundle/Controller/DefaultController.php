<?php

namespace ArtistShuffle\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use ArtistShuffle\UserBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/users", name="users_index")
     * @Template()
     */
    public function indexAction()
    {
        $users = $this->getDoctrine()->getRepository( 'ArtistShuffleUserBundle:User' )->findAll();

        return $this->render('ArtistShuffleUserBundle::index.html.twig', array( 'users' => $users ));
    }


    /**
     * @Route("/users/add", name="users_add")
     * @Template()
     */
    public function addUserAction(Request $request)
    {
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('username', 'text')
            ->add('email', 'text')
            ->add('password', 'text')
            ->add('save', 'submit', array('label' => 'Create User'))
            ->getForm();

        $form->handleRequest($request);

        if ( $form->isValid() )
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('users_index');
        }
        return $this->render('ArtistShuffleUserBundle::add.html.twig', array( 'form' => $form->createView() ) );
    }
}
