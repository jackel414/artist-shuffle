<?php

namespace ArtistShuffle\ArtistBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Genre
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ArtistShuffle\ArtistBundle\Entity\GenreRepository")
 */
class Genre
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
     * @ORM\OneToMany(targetEntity="Artist", mappedBy="genre")
     */
    protected $artists;

    /**
     * @ORM\ManyToOne(targetEntity="ArtistShuffle\UserBundle\Entity\User", inversedBy="genres")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;


    public function __construct()
    {
        $this->artists = new ArrayCollection();
    }

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
     * @return Genre
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
     * Add artist
     *
     * @param \ArtistShuffle\ArtistBundle\Entity\Artist $artist
     *
     * @return Genre
     */
    public function addArtist(\ArtistShuffle\ArtistBundle\Entity\Artist $artist)
    {
        $this->artists[] = $artist;

        return $this;
    }

    /**
     * Remove artist
     *
     * @param \ArtistShuffle\ArtistBundle\Entity\Artist $artist
     */
    public function removeArtist(\ArtistShuffle\ArtistBundle\Entity\Artist $artist)
    {
        $this->artists->removeElement($artist);
    }

    /**
     * Get artists
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArtists()
    {
        return $this->artists;
    }

    /**
     * Set user
     *
     * @param \ArtistShuffle\UserBundle\Entity\User $user
     *
     * @return Genre
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
