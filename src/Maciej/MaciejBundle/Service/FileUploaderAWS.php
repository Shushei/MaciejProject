<?php

namespace Maciej\MaciejBundle\Service;

Use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class FileUploaderAWS implements UploaderInterface
{

    private $s3client;
//bucket
    private $tableName;
    private $fileShowPath;

    public function __construct($s3Client, $showArgs)
    {
        $this->s3client = $s3Client;
        $this->fileShowPath = $showArgs;
    }

    public function setTableName($tableName)
    {
        return $this->tableName = $tableName;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function upload(UploadedFile $file)
    {
        $fileName['name'] = md5(uniqid()) . '.' . $file->guessExtension();
        $fileShowPath = $this->fileShowPath;

        if ($this->tableName == 'game') {
            $this->s3client->putObject(array(
                'Bucket' => 'maciej' . '.' . $this->tableName,
                'Key' => $fileName['name'],
                'SourceFile' => $file,
                'ACL' => 'public-read'
            ));
             $fileName['path'] = $fileShowPath['logo']."/".$fileName['name'];
        }
        if ($this->tableName == 'company') {
            $this->s3client->putObject(array(
                'Bucket' => 'maciej' . '.' . $this->tableName,
                'Key' => $fileName['name'],
                'SourceFile' => $file,
                'ACL' => 'public-read'
            ));
            $fileName['path'] = $fileShowPath['company']."/".$fileName['name'];
        }
        if ($this->tableName == 'gameimage') {

            $this->s3client->putObject(array(
                'Bucket' => 'maciej' . '.' . $this->tableName,
                'Key' => $fileName['name'],
                'SourceFile' => $file,
                'ACL' => 'public-read'
            ));
            $fileName['path'] = $fileShowPath['gameimage']."/".$fileName['name'];
        }
        return $fileName;
    }

    public function delete($fileName)
    {

        if ($this->tableName == 'game') {
            $this->s3client->deleteObject(array(
                'Bucket' => 'maciej.' . $this->tableName,
                'Key' => $fileName
            ));
        }
        if ($this->tableName == 'company') {
            $this->s3client->deleteObject(array(
                'Bucket' => 'maciej.' . $this->tableName,
                'Key' => $fileName
            ));
        }
        if ($this->tableName == 'gameimage') {
            $this->s3client->deleteObject(array(
                'Bucket' => 'maciej.' . $this->tableName,
                'Key' => $fileName
            ));
        }
    }


    public function download($fileName)
    {
        return $fileName;
    }

}
