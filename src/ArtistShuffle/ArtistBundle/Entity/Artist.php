<?php

namespace ArtistShuffle\ArtistBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Artist
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ArtistShuffle\ArtistBundle\Entity\ArtistRepository")
 */
class Artist
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="genre", type="integer")
     */
    private $genre;

    /**
     * @var integer
     *
     * @ORM\Column(name="spotify", type="integer")
     */
    private $spotify;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Artist
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set genre
     *
     * @param integer $genre
     *
     * @return Artist
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return integer
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set spotify
     *
     * @param integer $spotify
     *
     * @return Artist
     */
    public function setSpotify($spotify)
    {
        $this->spotify = $spotify;

        return $this;
    }

    /**
     * Get spotify
     *
     * @return integer
     */
    public function getSpotify()
    {
        return $this->spotify;
    }
}

