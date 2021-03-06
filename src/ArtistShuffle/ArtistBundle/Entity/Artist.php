<?php

namespace ArtistShuffle\ArtistBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
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
    protected $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="spotify", type="integer")
     */
    private $spotify;

    /**
     * @ORM\ManyToOne(targetEntity="Genre", inversedBy="artists")
     * @ORM\JoinColumn(name="genre_id", referencedColumnName="id")
     */
    protected $genre;

    /**
     * @ORM\ManyToOne(targetEntity="ArtistShuffle\UserBundle\Entity\User", inversedBy="artists")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;


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

    /**
     * Set genre
     *
     * @param \ArtistShuffle\ArtistBundle\Entity\Genre $genre
     *
     * @return Artist
     */
    public function setGenre(\ArtistShuffle\ArtistBundle\Entity\Genre $genre = null)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return \ArtistShuffle\ArtistBundle\Entity\Genre
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set user
     *
     * @param \ArtistShuffle\UserBundle\Entity\User $user
     *
     * @return Artist
     */
    public function setUser(\ArtistShuffle\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ArtistShuffle\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
