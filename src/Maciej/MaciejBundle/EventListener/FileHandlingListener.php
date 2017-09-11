<?php

namespace Maciej\MaciejBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Maciej\MaciejBundle\Entity\Company;
use Maciej\MaciejBundle\Entity\GameImage;
use Symfony\Component\HttpFoundation\File\File;

class FileHandlingListener
{

    private $uploader;

    public function __construct($uploader)
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
        
        if ($entity instanceof Company && $file = $entity->getClogo() instanceof UploadedFile) {
            $this->uploader->setTableName('company');
            $file = $entity->getClogo();
            $fileName = $this->uploader->upload($file);
            $entity->setClogo($fileName['path']);
            $entity->setFileName($fileName['name']);
        
        }
        if ($entity instanceof GameImage && $file = $entity->getGameimage() instanceof UploadedFile) {
            $this->uploader->setTableName('gameimage');
            $file = $entity->getGameimage();
            $fileName = $this->uploader->upload($file);
            $entity->setGameimage($fileName['path']);
            $entity->setFileName($fileName['name']);
        
        }

        return;
    }

    private function removeFile($entity)
    {
        
        if ($entity instanceof Company) {
            $this->uploader->setTableName('company');
            $fileName = $entity->getFileName();
            $this->uploader->delete($fileName);
        }
        if ($entity instanceof GameImage) {
            $this->uploader->setTableName('gameimage');
            $fileName = $entity->getFileName();
            $this->uploader->delete($fileName);
        }
        return;
    }


}
