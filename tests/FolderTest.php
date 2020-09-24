<?php

use PHPUnit\Framework\TestCase;
use App\Model\Folder;

final class FolderTest extends TestCase
{
    public function testFolderPath(){
        $folder = new Folder();
        $folder->setName('my-folder');
    
        $this->assertEquals(
            'my-folder/',
            $folder->getFullPath()
        );
        
        $subFolder = new Folder();
        $subFolder->setName('my sub-folder');
        $folder->addFolder($subFolder);
        
        $this->assertEquals(
            'my-folder/my sub-folder/',
            $subFolder->getFullPath()
        );
        
        $subSubFolder = new Folder();
        $subSubFolder->setName('my Sub sub-folder');
        $subFolder->addFolder($subSubFolder);
        
        $this->assertEquals(
            'my-folder/my sub-folder/my Sub sub-folder/',
            $subSubFolder->getFullPath()
        );
    }
    
    public function testFolderScan(){
    
    }
}