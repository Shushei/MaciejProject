<?php

namespace Maciej\MaciejBundle\Service;

Use Symfony\Component\HttpFoundation\File\UploadedFile;
use MaciejBundle\Service\UploaderInterface;

class FileUploaderAWS implements UploaderInterface
{

    private $s3client;
//bucket
    private $tableName;

    public function __construct($s3Client)
    {
        $this->s3client = $s3Client;
    }

    public function upload(UploadedFile $file)
    {
        return $this->s3client;
    }

    public function delete($fileName)
    {
        return $this->s3client;
    }

}
