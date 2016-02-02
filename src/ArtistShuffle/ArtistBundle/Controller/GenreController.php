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

class GenreController extends Controller
{
    /**
     * @Route("/genres", name="genres_index")
     * @Template()
     */
    public function indexAction()
    {
        $genres = $this->getDoctrine()->getRepository( 'ArtistShuffleArtistBundle:Genre' )->findAll();

        return $this->render('ArtistShuffleArtistBundle::genres/index.html.twig', array( 'genres' => $genres ));
    }

    /**
     * @Route("/genres/add", name="genres_add")
     * @Template()
     */
    public function addAction(Request $request)
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

            return $this->redirectToRoute('genres_index');
        }
        return $this->render('ArtistShuffleArtistBundle::genres/add.html.twig', array( 'form' => $form->createView() ) );
    }
}
