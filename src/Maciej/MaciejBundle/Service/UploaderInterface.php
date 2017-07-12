<?php
namespace Maciej\MaciejBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;


interface UploaderInterface
{
    
    public function upload(UploadedFile $file);
    public function delete($fileName);
    
    
}

