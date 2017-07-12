<?php

namespace Maciej\MaciejBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Maciej\MaciejBundle\Entity\Game;
use Maciej\MaciejBundle\Entity\Company;
use Maciej\MaciejBundle\Entity\GameImage;
use Maciej\MaciejBundle\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\File;

class FileHandlingListener
{

    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->removeFile($entity);
    }

    private function uploadFile($entity)
    {
        if ($entity instanceof Game && $file = $entity->getLogo() instanceof UploadedFile) {
            $this->uploader->setTableName('game');
            $file = $entity->getLogo();
            $fileName = $this->uploader->upload($file);
            $entity->setLogo($fileName);
        } elseif ($entity instanceof Game && !empty($entity->getLogo())) {
            $this->uploader->setTableName('game');
            $logo = $entity->getLogo();
            $fileName = $logo->getFileName();
            $entity->setClogo($fileName);
        }
        if ($entity instanceof Company && $file = $entity->getClogo() instanceof UploadedFile) {
            $this->uploader->setTableName('company');
            $file = $entity->getClogo();
            $fileName = $this->uploader->upload($file);
            $entity->setClogo($fileName);
        } elseif ($entity instanceof Company && !empty($entity->getClogo())) {
            $this->uploader->setTableName('company');
            $clogo = $entity->getClogo();
            $fileName = $clogo->getFileName();
            $entity->setClogo($fileName);
        }
        if ($entity instanceof GameImage && $file = $entity->getGameimage() instanceof UploadedFile) {
            $this->uploader->setTableName('gameimage');
            $file = $entity->getGameimage();
            $fileName = $this->uploader->upload($file);
            $entity->setGameimage($fileName);
        } elseif ($entity instanceof GameImage && !empty($entity->getGameimage())) {
            $this->uploader->setTableName('gameimage');
            $gameimage = $entity->getGameimage();
            $fileName = $gameimage->getFileName();
            $entity->setClogo($fileName);
        }

        return;
    }

    private function removeFile($entity)
    {
        if ($entity instanceof Game) {
            $this->uploader->setTableName('game');
            $fileName = $entity->getLogo();
            $this->uploader->delete($fileName);
        }
        if ($entity instanceof Company) {
            $this->uploader->setTableName('company');
            $fileName = $entity->getClogo();
            $this->uploader->delete($fileName);
        }
        if ($entity instanceof GameImage) {
            $this->uploader->setTableName('gameimage');
            $fileName = $entity->getGameimage();
            $this->uploader->delete($fileName);
        }
        return;
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Company) {
            $filename = $entity->getClogo();
            if (!empty($filename)) {
                $fileDir = $this->uploader->getFileDir();
                $entity->setClogo(new File($fileDir['company'] . '/' . $filename));
            }
        }
        if ($entity instanceof Game) {
            $filename = $entity->getLogo();
            if (!empty($filename)) {
                $fileDir = $this->uploader->getFileDir();
                $entity->setLogo(new File($fileDir['logo'] . '/' . $filename));
            }
        }
        if ($entity instanceof GameImage) {
            $filename = $entity->getGameImage();
            if (!empty($filename)) {
                $fileDir = $this->uploader->getFileDir();
                $entity->setGameImage(new File($fileDir['gameimage'] . '/' . $filename));
            }
        }
        return;
    }

}
