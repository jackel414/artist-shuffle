<?php

namespace ArtistShuffle\ArtistBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
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
    public function addArtistAction()
    {
        return $this->render('ArtistShuffleArtistBundle::add.html.twig');
    }
}
