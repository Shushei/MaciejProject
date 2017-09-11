<?php

namespace Maciej\MaciejBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="Maciej\MaciejBundle\Repository\GameImageRepository")
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

    /**
     * @ORM\Column(type="string")
     * 
     */
    private $fileName;

    /**
     * @ORM\Column(type="boolean")
     * 
     */
    private $isLogo;

    public function getIsLogo()
    {
        return $this->isLogo;
    }

    public function setIsLogo($isLogo)
    {
        return $this->isLogo = $isLogo;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function setFileName($fileName)
    {
        return $this->fileName = $fileName;
    }

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
