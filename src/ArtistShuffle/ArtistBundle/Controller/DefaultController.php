<?php

namespace ArtistShuffle\ArtistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use ArtistShuffle\ArtistBundle\Entity\Artist;
use ArtistShuffle\ArtistBundle\Entity\Genre;
use Doctrine\ORM\EntityRepository;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('ArtistShuffleArtistBundle::index.html.twig');
    }

    /**
     * @Route("/artists", name="artists_index")
     * @Template()
     */
    public function indexArtistAction()
    {
        $artists = $this->getDoctrine()->getRepository( 'ArtistShuffleArtistBundle:Artist' )->findAll();

        return $this->render('ArtistShuffleArtistBundle::artists/index.html.twig', array( 'artists' => $artists ));
    }

    /**
     * @Route("/artists/add", name="artists_add")
     * @Template()
     */
    public function addArtistAction(Request $request)
    {
        $artist = new Artist();
        $form = $this->createFormBuilder($artist)
            ->add('name', 'text')
            ->add('genre', 'entity', array( 
                'class' => 'ArtistShuffleArtistBundle:Genre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
                'placeholder' => '',
            ))
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
     * @Route("/genres", name="genres_index")
     * @Template()
     */
    public function indexGenreAction()
    {
        $genres = $this->getDoctrine()->getRepository( 'ArtistShuffleArtistBundle:Genre' )->findAll();

        return $this->render('ArtistShuffleArtistBundle::genres/index.html.twig', array( 'genres' => $genres ));
    }

    /**
     * @Route("/genres/add", name="genres_add")
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

    /**
     * @Route("/shuffle/{genre}", name="shuffle")
     * @Template()
     */
    public function shuffleAction($genre = null)
    {
        if ( $genre )
        {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                'SELECT a
                FROM ArtistShuffleArtistBundle:Artist a
                WHERE a.genre = :genre
                ORDER BY a.name ASC'
            )->setParameter('genre', $genre);
            $artists = $query->getResult();
        }
        else
        {
            $artists = $this->getDoctrine()->getRepository( 'ArtistShuffleArtistBundle:Artist' )->findAll();
        }

        $index = rand( 0, ( count($artists) - 1) );
        $artist = $artists[$index];

        $number = count($artists);                
        return $this->render('ArtistShuffleArtistBundle::shuffle.html.twig', array( 'artist' => $artist ));
    }
}
