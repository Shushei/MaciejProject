<?php

namespace Maciej\MaciejBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

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
 *@ORM\Column(type="string", nullable = true)
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
     * @param \MaciejBundle\Entity\Games $game
     *
     * @return Companies
     */
    public function addGame(\MaciejBundle\Entity\Games $game)
    {
        $this->games[] = $game;

        return $this;
    }

    /**
     * Remove game
     *
     * @param \MaciejBundle\Entity\Games $game
     */
    public function removeGame(\MaciejBundle\Entity\Games $game)
    {
        $this->games->removeElement($game);
    }

    /**
     * Get games
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGames()
    {
        return $this->games;
    }
}
