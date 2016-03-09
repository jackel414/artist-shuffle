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

class ArtistController extends Controller
{
    /**
     * @Route("/artists", name="artists_index")
     * @Template()
     */
    public function indexAction()
    {
        $artists = $this->getDoctrine()->getRepository( 'ArtistShuffleArtistBundle:Artist' )->findAll( $this->getUser()->getId() );

        return $this->render('ArtistShuffleArtistBundle::artists/index.html.twig', array( 'artists' => $artists ));
    }

    /**
     * @Route("/artists/add", name="artists_add")
     * @Template()
     */
    public function addAction(Request $request)
    {
        $artist = new Artist();
        $artist->setUser($this->getUser());
        $form = $this->createFormBuilder($artist)
            ->add('name', 'text')
            ->add('genre', 'entity', array( 
                'class' => 'ArtistShuffleArtistBundle:Genre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.user = :user')->setParameter('user', $this->getUser()->getId() )->orderBy('u.name', 'ASC');
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
            $name = $artist->getName();
            $existing_artists = $this->getDoctrine()->getRepository( 'ArtistShuffleArtistBundle:Artist' )->findAll( $this->getUser()->getId() );

            $existing_artist_names = array();
            foreach ( $existing_artists as $existing_artist )
            {
                array_push( $existing_artist_names, $existing_artist->getName() );
            }

            if ( in_array($name, $existing_artist_names) )
            {
                $form->get('name')->addError(new FormError('This artist already exists.'));
                return $this->render('ArtistShuffleArtistBundle::artists/add.html.twig', array( 'form' => $form->createView() ) );
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($artist);
            $em->flush();

            return $this->redirectToRoute('artists_index');
        }
        return $this->render('ArtistShuffleArtistBundle::artists/add.html.twig', array( 'form' => $form->createView() ) );
    }
}
