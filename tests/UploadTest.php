<?php


use PHPUnit\Framework\TestCase;

use App\Model\File;

class UploadTest extends TestCase
{
    public function testFolderPath(){
        $file = new File();
        $file->setName('My File to upload.txt');

        $this->assertEquals(
            'my-folder/my-file-to-upload-tx_XXX',
            $file->generateS3Key('My_folder', 'XXX')
        );
    }
}
