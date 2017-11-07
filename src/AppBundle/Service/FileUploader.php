<?php
namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetPath;

    public function __construct($targetPath)
    {
        $this->targetPath = $targetPath;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetPath(), $fileName);

        return $fileName;
    }

    public function base64Converter($base64_image_string, $output_file){
        $splited = explode(',', substr( $base64_image_string , 5 ) , 2);

        $mime = $splited[0];
        $data = $splited[1];

        $mime_split_without_base64 = explode(';', $mime,2);
        $mime_split  =explode('/', $mime_split_without_base64[0],2);
        if(count($mime_split)==2)
        {
            $extension = $mime_split[1];
            if($extension == 'jpeg') $extension='jpg';

            $fileName = md5(uniqid()).'.'.$extension;

            $output_file_with_extension = $output_file.'/'.$fileName;
        }

        file_put_contents( $output_file_with_extension, base64_decode($data) );

        return $fileName;
    }

    public function getTargetPath()
    {
        return $this->targetPath;
    }
}