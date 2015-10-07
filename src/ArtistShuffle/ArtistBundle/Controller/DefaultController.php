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
    public function indexAction($name = null)
    {
        return $this->render('ArtistShuffleArtistBundle::index.html.twig');
    }

    /**
     * @Route("/add")
     * @Template()
     */
    public function addArtistAction(Request $request)
    {
        // create a artist and give it some dummy data for this example
        $artist = new Artist();
        //$task->setTask('Write a blog post');
        //$task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($artist)
            ->add('name', 'text')
            ->add('genre', 'text')
            ->add('spotify', 'text')
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

        /*
        $this->request = Request::createFromGlobals();
        $method = strtolower($this->request->getMethod());

        if ( $method === 'post' )
        {
            //do stuff...
        }
        elseif ( $method === 'get' )
        {
            return $this->render( 'ArtistShuffleArtistBundle::add.html.twig' );
        }
        */
    }
}
