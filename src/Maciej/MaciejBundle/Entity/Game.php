<?php

namespace Maciej\MaciejBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="Maciej\UserBundle\Repository\GameRepository")
 * @ORM\Table(name="game")
 */
class Game
{

    /**
     * @ORM\Column( type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $title;

    /**
     * @ORM\OneToMany(targetEntity="GameImage", mappedBy="title")
     * @Groups({"list"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="games")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * @Groups({"list"})
     */
    protected $company;

    /**
     *  @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     */
    protected $releaseDate;

    /**
     *  @ORM\Column(type="string", nullable = true)
     */
    private $logolink;

    public function getLogoLink()
    {
        return $this->logolink;
    }

    public function setLogoLink($logolink)
    {
        $this->logolink = $logolink;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;
    }

    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTime $releaseDate = null)
    {
        $this->releaseDate = $releaseDate;
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
     * Add image
     *
     * @param \Maciej\MaciejBundle\Entity\GameImage $image
     *
     * @return Games
     */
    public function addImage(\Maciej\MaciejBundle\Entity\GameImage $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \Maciej\MaciejBundle\Entity\GameImage $image
     */
    public function removeImage(\Maciej\MaciejBundle\Entity\GameImage $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

}
