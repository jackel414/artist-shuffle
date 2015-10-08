<?php

namespace ArtistShuffle\ArtistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use ArtistShuffle\ArtistBundle\Entity\Artist;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    { 
        $artists = $this->getDoctrine()->getRepository( 'ArtistShuffleArtistBundle:Artist' )->findAll();

        return $this->render('ArtistShuffleArtistBundle::index.html.twig', array( 'artists' => $artists ));
    }

    /**
     * @Route("/add", name="add")
     * @Template()
     */
    public function addArtistAction(Request $request)
    {
        $artist = new Artist();
        $form = $this->createFormBuilder($artist)
            ->add('name', 'text')
            ->add('genre', 'text')
            ->add('spotify', 'checkbox', array( 'required' => false ))
            ->add('save', 'submit', array('label' => 'Create Artist'))
            ->getForm();

        $form->handleRequest($request);

        if ( $form->isValid() )
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($artist);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }
        return $this->render('ArtistShuffleArtistBundle::add.html.twig', array( 'form' => $form->createView() ) );
    }
}
