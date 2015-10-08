<?php

namespace ArtistShuffle\ArtistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use ArtistShuffle\ArtistBundle\Entity\Artist;
use ArtistShuffle\ArtistBundle\Entity\Genre;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        $artists = $this->getDoctrine()->getRepository( 'ArtistShuffleArtistBundle:Artist' )->findAll();
        $genres = $this->getDoctrine()->getRepository( 'ArtistShuffleArtistBundle:Genre' )->findAll();

        return $this->render('ArtistShuffleArtistBundle::index.html.twig', array( 'artists' => $artists, 'genres' => $genres ));
    }

    /**
     * @Route("/artists/add", name="add_artist")
     * @Template()
     */
    public function addArtistAction(Request $request)
    {
        $artist = new Artist();
        $form = $this->createFormBuilder($artist)
            ->add('name', 'text')
            ->add('genre', 'entity', array( 'class' => 'ArtistShuffleArtistBundle:Genre', 'choice_label' => 'name' ))
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
        return $this->render('ArtistShuffleArtistBundle::artists/add.html.twig', array( 'form' => $form->createView() ) );
    }

    /**
     * @Route("genres/add", name="add_genre")
     * @Template()
     */
    public function addGenreAction(Request $request)
    {
        $genre = new Genre();
        $form = $this->createFormBuilder($genre)
            ->add('name', 'text')
            ->add('save', 'submit', array('label' => 'Create Genre'))
            ->getForm();

        $form->handleRequest($request);

        if ( $form->isValid() )
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($genre);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }
        return $this->render('ArtistShuffleArtistBundle::genres/add.html.twig', array( 'form' => $form->createView() ) );
    }
}
