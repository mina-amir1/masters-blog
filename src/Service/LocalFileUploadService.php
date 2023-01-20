<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Exception;

class LocalFileUploadService {

    private string $destination;
    public const UserPhoto = 'userPhoto';
    public const PostPhoto = 'postPhoto';
    public const directories = [
        self::PostPhoto => 'posts',
        self::UserPhoto =>'uploads'
    ];

    public function __construct(string $destination)
    {
        $this->destination = $destination;
    }

    public function uploadFile(UploadedFile $uploadedFile, string $photoType = self::UserPhoto): ?string
    {
        try{
        $originalName = pathinfo($uploadedFile->getClientOriginalName(),PATHINFO_FILENAME);
        $newName = $originalName. uniqid('', true).'.'.$uploadedFile->guessExtension();
        $uploadedFile->move($this->destination.self::directories[$photoType],$newName);}
        catch (Exception $exception){
            echo 'Error in uploading file: '.$exception->getMessage();
            return 0;
        }
        return  $newName;
    }
}