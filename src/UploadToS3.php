<?php


namespace App;


use App\Helper\Env;
use App\Model\File;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;

class UploadToS3
{
    private $client;
    
    private function getClient(){
        if(!$this->client){
            $this->client = new S3Client([
                'version' => 'latest',
                'region'  => Env::get('AWS_REGION'),
                'endpoint' => Env::get('AWS_ENDPOINT'),
                'credentials' => [
                    'key'    => Env::get('AWS_ID'),
                    'secret' => Env::get('AWS_PRIVATE'),
                ],
            ]);
        }
        
        return $this->client;
    }
    
    private function getContentDisposition(File $file){
        return 'attachment; filename="'.$file->getName().'"';
    }
    
    public function uploadFile(File $file, $mainFolder){
        $uploader = new MultipartUploader($this->getClient(), $file->getRealPath(), [
            'bucket' => 'op-serv',
            'key' => $file->generateS3Key($mainFolder),
            'concurrency' => 2,
            'part_size' => 100000000, // 100 Mo
            'before_initiate' => function (\Aws\Command $command) use ($file) {
                $command['ContentType'] = $file->getMineType();
                $command['ContentDisposition'] = $this->getContentDisposition($file);
            },
        ]);
    
        $uploader->upload();
    }
}