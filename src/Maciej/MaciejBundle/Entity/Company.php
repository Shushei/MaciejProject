<?php

namespace Maciej\MaciejBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="Company")
 * @UniqueEntity("company")
 */
class Company
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Game", mappedBy="company")
     * @Groups({"games"})
     */
    private $games;

    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     */
    protected $company;

    /**
     * @ORM\Column(type="date")
     * @Assert\Type("\DateTime")
     * @Assert\NotBlank()
     */
    protected $founded;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $ownername;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $ownersurname;

    /**
     * @ORM\Column(type="string", nullable = true)
     * 
     * @Assert\File
     * 
     */
    private $clogo;

    public function getClogo()
    {
        return $this->clogo;
    }

    public function setClogo($clogo)
    {
        $this->clogo = $clogo;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        return $this->company = $company;
    }

    public function getFounded()
    {
        return $this->founded;
    }

    public function setFounded($founded)
    {
        return $this->founded = $founded;
    }

    public function getOwnername()
    {
        return $this->ownername;
    }

    public function setOwnername($ownername)
    {
        return $this->ownername = $ownername;
    }

    public function getOwnersurname()
    {
        return $this->ownersurname;
    }

    public function setOwnersurname($ownersurname)
    {
        return $this->ownersurname = $ownersurname;
    }

    /**
     * Add game
     *
     * @param \Maciej\MaciejBundle\Entity\Game $game
     *
     * @return games
     */
    public function addGame(\Maciej\MaciejBundle\Entity\Game $game)
    {
        $this->games[] = $game;

        return $this;
    }

    /**
     * Remove Game
     *
     * @param \Maciej\MaciejBundle\Entity\Game $Game
     */
    public function removeGame(\Maciej\MaciejBundle\Entity\Game $Game)
    {
        $this->games->removeElement($game);
    }

    /**
     * Get Games
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGames()
    {
        return $this->games;
    }

}
