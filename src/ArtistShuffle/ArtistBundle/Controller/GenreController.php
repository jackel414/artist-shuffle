<?php

namespace ArtistShuffle\ArtistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ArtistShuffle\ArtistBundle\Entity\Artist;
use ArtistShuffle\ArtistBundle\Entity\Genre;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormError;

class GenreController extends Controller
{
    /**
     * @Route("/genres", name="genres_index")
     * @Template()
     */
    public function indexAction()
    {
        $genres = $this->getDoctrine()->getRepository( 'ArtistShuffleArtistBundle:Genre' )->findAll( $this->getUser()->getId() );

        return $this->render('ArtistShuffleArtistBundle::genres/index.html.twig', array( 'genres' => $genres ));
    }

    /**
     * @Route("/genres/add", name="genres_add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $genre = new Genre();
        $genre->setUser($this->getUser());
        $form = $this->createFormBuilder($genre)
            ->add('name', 'text')
            ->add('save', 'submit', array('label' => 'Create Genre'))
            ->getForm();

        $form->handleRequest($request);

        if ( $form->isValid() )
        {
            $name = $genre->getName();
            $existing_genres = $this->getDoctrine()->getRepository( 'ArtistShuffleArtistBundle:Genre' )->findAll( $this->getUser()->getId() );

            $existing_genre_names = array();
            foreach ( $existing_genres as $existing_genre )
            {
                array_push( $existing_genre_names, $existing_genre->getName() );
            }

            if ( in_array($name, $existing_genre_names) )
            {
                $form->get('name')->addError(new FormError('This genre already exists.'));
                return $this->render('ArtistShuffleArtistBundle::genres/add.html.twig', array( 'form' => $form->createView() ) );
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($genre);
            $em->flush();

            return $this->redirectToRoute('genres_index');
        }
        return $this->render('ArtistShuffleArtistBundle::genres/add.html.twig', array( 'form' => $form->createView() ) );
    }
}