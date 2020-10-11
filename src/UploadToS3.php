<?php


namespace App;


use App\Helper\Env;
use App\Model\File;
use Aws\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;
use Aws\S3\ObjectUploader;

class UploadToS3
{
    private $client;
    
    private function getClient(){
        if(!$this->client){
            $options = [
                'version' => 'latest',
                'region'  => Env::get('AWS_REGION'),
                'credentials' => [
                    'key'    => Env::get('AWS_ID'),
                    'secret' => Env::get('AWS_PRIVATE'),
                ],
            ];
            
            if(Env::get('AWS_ENDPOINT')){
                $options['endpoint'] = Env::get('AWS_ENDPOINT');
            }
            
            $this->client = new S3Client($options);
        }
        
        return $this->client;
    }
    
    private function getContentDisposition(File $file){
        $filename = mb_convert_encoding($file->getName(), "US-ASCII");
        return 'attachment; filename="'.$filename.'"';
    }
    
    /**
     * From https://docs.aws.amazon.com/fr_fr/sdk-for-php/v3/developer-guide/s3-multipart-upload.html
     * @param File $file
     * @param $mainFolder
     */
    public function uploadFile(File $file, $mainFolder){
        $source = fopen($file->getRealPath(), 'rb');
        $key = $file->generateS3Key($mainFolder);
        $before = function (\Aws\Command $command) use ($file) {
            $command['ContentType'] = $file->getMineType();
            $command['ContentDisposition'] = $this->getContentDisposition($file);
        };
        
        $uploader = new ObjectUploader(
            $this->getClient(),
            Env::get('AWS_BUCKET'),
            $key,
            $source,
            'private',
            ['before_upload' => $before]
        );
    
        do {
            try {
                $result = $uploader->upload();
                if ($result["@metadata"]["statusCode"] == '200') {
                    // print('<p>File successfully uploaded to ' . $result["ObjectURL"] . '.</p>');
                }
            } catch (MultipartUploadException $e) {
                rewind($source);
                $uploader = new MultipartUploader($this->getClient(), $source, [
                    'state' => $e->getState(),
                    'bucket' => Env::get('AWS_BUCKET'),
                    'key' => $file->generateS3Key($mainFolder),
                    'concurrency' => 2,
                    'part_size' => 100000000, // 100 Mo
                    'before_initiate' => $before,
                ]);
            }
        } while (!isset($result));
    }
}