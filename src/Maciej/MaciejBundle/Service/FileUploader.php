<?php

namespace Maciej\MaciejBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Filesystem\Filesystem;
use Maciej\MaciejBundle\Service\UploaderInterface;

class FileUploader implements UploaderInterface
{

    private $fileDir;
    public $tableName;

    public function __construct($args)
    {

        $this->fileDir = $args;
    }


    public function setTableName($tableName)
    {
        return $this->tableName = $tableName;
    }

    public function getTableName()
    {
        return $this->TableName;
    }

    public function setFileDir($fileDir)
    {
        return $this->fileDir = $fileDir;
    }

    public function getFileDir()
    {
        return $this->fileDir;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $fileDir = $this->fileDir;
        if ($this->tableName == 'games') {
            $file->move($fileDir['logo'], $fileName);
        }
        if ($this->tableName == 'companies') {
            $file->move($fileDir['company'], $fileName);
        }
        if ($this->tableName == 'gameimage') {
            $file->move($fileDir['image'], $fileName);
        }
        return $fileName;
    }

    public function delete($fileName)
    {
        $file = new File($fileName);
        $filedelete = new Filesystem();
        $filedelete->remove($file);
    }

}
