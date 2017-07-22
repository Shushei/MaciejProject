<?php
namespace Maciej\MaciejBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="gameimage")
 */

class GameImage 
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="images")
     * @ORM\JoinColumn(name="title_id", referencedColumnName="id")
     */
    protected $title;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\File
     * @Groups({"images"})
     */
    private $gameimage;
    
    public function getId()
    {
        return $this->id;
    }
    public function setTitle($title)
    {
       return $this->title = $title;
       
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setGameimage($gameimage)
    {
        return $this->gameimage = $gameimage;
    }
    public function getGameimage()
    {
        return $this->gameimage;
    }
}
