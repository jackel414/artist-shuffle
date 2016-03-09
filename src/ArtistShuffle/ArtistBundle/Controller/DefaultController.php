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

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        //check if user is logged in. if so - redirect to shuffle page
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('shuffle');
        }

        return $this->render('ArtistShuffleArtistBundle::index.html.twig');
    }

    /**
     * @Route("/shuffle", name="shuffle")
     * @Template()
     */
    public function shuffleAction(Request $request)
    {
        //Get the current method from the HTTP headers
        $method = strtolower($request->getMethod());

        if ( $method === 'post' )
        {
            $genre = $request->request->get('genre');

            if ( $genre )
            {
                $em = $this->getDoctrine()->getManager();
                $query = $em->createQuery(
                    'SELECT a
                    FROM ArtistShuffleArtistBundle:Artist a
                    WHERE a.genre = :genre
                    AND a.user = :user
                    ORDER BY a.name ASC'
                )->setParameter('genre', $genre)->setParameter('user', $this->getUser()->getId());
                $artists = $query->getResult();
            }
            else
            {
                $artists = $this->getDoctrine()->getRepository( 'ArtistShuffleArtistBundle:Artist' )->findAll( $this->getUser()->getId() );
            }

            $index = rand( 0, ( count($artists) - 1) );
            $artist = $artists[$index];

            $artist_name = $artist->getName();

            $response = new Response( $artist_name );
            $response->headers->set('Content_Type', 'application/json');

            return $response;
        }

        $genre_form = $this->createFormBuilder()
            ->add('genre', 'entity', array( 
                'class' => 'ArtistShuffleArtistBundle:Genre',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')->where('u.user = :user')->setParameter('user', $this->getUser()->getId() )->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
                'placeholder' => 'Any Genre',
                'label' => false
            ))
            ->getForm();

        return $this->render('ArtistShuffleArtistBundle::shuffle.html.twig', array( 'genre_form' => $genre_form->createView() ));
    }
}
