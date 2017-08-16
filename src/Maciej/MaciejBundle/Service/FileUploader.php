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
    private $fileShowPath;

    public function __construct($args, $showArgs)
    {

        $this->fileDir = $args;
        $this->fileShowPath = $showArgs;
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
        $fileName['name'] = md5(uniqid()) . '.' . $file->guessExtension();
        $fileDir = $this->fileDir;
        $fileShowPath = $this->fileShowPath;
        if ($this->tableName == 'game') {
            $file->move($fileDir['logo'], $fileName['name']);
            $fileName['path'] = $fileShowPath['logo']."/".$fileName['name'];
        }
        if ($this->tableName == 'company') {
            $file->move($fileDir['company'], $fileName['name']);
            $fileName['path'] = $fileShowPath['company']."/".$fileName['name'];
        }
        if ($this->tableName == 'gameimage') {
            $file->move($fileDir['gameimage'], $fileName);
            $fileName['path'] = $fileShowPath['gameimage']."/".$fileName['name'];
        }
        return $fileName;
    }

    public function delete($fileName)
    {
        
        $fileDir = $this->fileDir;
        if ($this->tableName == 'game') {
            $file = new File($fileDir['logo'] . '/' . $fileName);
        }
        if ($this->tableName == 'company') {
            $file = new File($fileDir['company'] . '/' . $fileName);
        }
        if ($this->tableName == 'gameimage') {
            $file = new File($fileDir['gameimage'] . '/' . $fileName);
        }

        $filedelete = new Filesystem();
        $filedelete->remove($file);
        
    }

    public function download($fileName)
    {
        $fileDir = $this->fileDir;
        if ($this->tableName == 'game') {
            $file = new File($fileDir['logo'] . '/' . $fileName);
        }
        if ($this->tableName == 'company') {
            $file = new File($fileDir['company'] . '/' . $fileName);
        }
        if ($this->tableName == 'gameimage') {
            $file = new File($fileDir['gameimage'] . '/' . $fileName);
        }
        return $file;
    }
   
}
