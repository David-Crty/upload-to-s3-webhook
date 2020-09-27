<?php


use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    public function testFilePath(){
        $folder = new \App\Model\Folder();
        $folder->setName('My Folder');
        
        $subFolder = new \App\Model\Folder();
        $subFolder->setName('my-sub-folder');
        $folder->addFolder($subFolder);
        
        $file = new \App\Model\File();
        $file->setName('my-file.txt');
        $subFolder->addFile($file);
        
        $this->assertEquals(
            'My Folder/my-sub-folder/my-file.txt',
            $file->getPath()
        );
        
    }
}
