<?php

namespace Maciej\MaciejBundle\Service;

Use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class FileUploaderAWS implements UploaderInterface
{

    private $s3client;
//bucket
    private $tableName;

    public function __construct($s3Client)
    {
        $this->s3client = $s3Client;
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
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        if ($this->tableName == 'game') {
            $this->s3client->putObject(array(
                'Bucket' => 'maciej' . '.' . $this->tableName,
                'Key' => $fileName,
                'SourceFile' => $file,
                'ACL' => 'public-read'
            ));
        }
        if ($this->tableName == 'company') {
            $this->s3client->putObject(array(
                'Bucket' => 'maciej' . '.' . $this->tableName,
                'Key' => $fileName,
                'SourceFile' => $file,
                'ACL' => 'public-read'
            ));
        }
        if ($this->tableName == 'gameimage') {

            $this->s3client->putObject(array(
                'Bucket' => 'maciej' . '.' . $this->tableName,
                'Key' => $fileName,
                'SourceFile' => $file,
                'ACL' => 'public-read'
            ));
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

    public function listing()
    {
        $client = $this->s3client;
        $iterator = $client->listObjects(array(
            'Bucket' => 'maciej' . '.' . $this->tableName,
        ));
        if (!empty($iterator['Contents'])) {
            foreach ($iterator['Contents'] as $object) {
                $key = $object['Key'];
                $url[] = array('key' => $object['Key'], 'url' => $client->getObjectUrl('maciej.' . $this->tableName, $key));
            }
        }else{
            $url = null;
        }
        return $url;
    }

    public function download($fileName)
    {
        return $fileName;
    }

}
