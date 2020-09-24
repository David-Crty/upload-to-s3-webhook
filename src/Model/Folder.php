<?php


namespace App\Model;


use Doctrine\Common\Collections\ArrayCollection;

class Folder
{
    private string $name;
    
    private ?Folder $parent = null;
    
    /** @var ArrayCollection|File[] */
    private ArrayCollection $files;
    
    /** @var ArrayCollection|Folder[] */
    private ArrayCollection $folders;
    
    public function __construct(){
        $this->files = new ArrayCollection();
        $this->folders = new ArrayCollection();
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    
    /**
     * @return Folder|null
     */
    public function getParent(): ?Folder
    {
        return $this->parent;
    }
    
    /**
     * @param Folder|null $parent
     */
    public function setParent(?Folder $parent): void
    {
        $this->parent = $parent;
    }
    
    /**
     * @return ArrayCollection|File[]
     */
    public function getFiles(): ArrayCollection
    {
        return $this->files;
    }
    
    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setFolder($this);
        }
        
        return $this;
    }
    
    
    public function removeFile(File $file): self
    {
        if ($this->files->contains($file)) {
            $this->files->removeElement($file);
            // set the owning side to null (unless already changed)
            if ($file->getFolder() === $this) {
                $file->setFolder(null);
            }
        }
        
        return $this;
    }    
    /**
     * @return ArrayCollection|Folder[]
     */
    public function getFolders(): ArrayCollection
    {
        return $this->folders;
    }
    
    public function addFolder(Folder $folder): self
    {
        if (!$this->folders->contains($folder)) {
            $this->folders[] = $folder;
            $folder->setParent($this);
        }
        
        return $this;
    }
    
    
    public function removeFolder(Folder $folder): self
    {
        if ($this->folders->contains($folder)) {
            $this->folders->removeElement($folder);
            // set the owning side to null (unless already changed)
            if ($folder->getParent() === $this) {
                $folder->setParent(null);
            }
        }
        
        return $this;
    }
    
    public function getFullPath(){
        return $this->getRecursivePath().'/';
    }
    
    public function getRecursivePath(){
        $parentPath = ($this->getParent())
            ? $this->getParent()->getRecursivePath().'/'
            : null;
    
        return $parentPath.$this->getName();
    }
}