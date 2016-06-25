<?php
namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="upl_files")
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Entity\FileRepository")
 */
class UplFile
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /*
     * uploaded file pointer
     */
    public $filePointer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $localname;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $localpath;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id" )
     */
    protected $oUser;

    /**
     * @ORM\OneToMany(targetEntity="FTPDownload", mappedBy="oFile")
     *
     * @var ArrayCollection $fileDownloads
     */
    protected $fileDownloads;

    public function __construct(){
        $this->fileDownloads = new ArrayCollection();
    }



    /**
     * @return ArrayCollection A Doctrine ArrayCollection
     */
    public function getFileDownloads()
    {
        return $this->fileDownloads;
    }



    /**
     * Add fileDownload
     *
     * @param \Blogger\BlogBundle\Entity\FTPDownload $fileDownload
     * @return UplFile
     */
    public function addFileDownload (\Blogger\BlogBundle\Entity\FTPDownload $fileDownload)
    {
        $this->userRoles[] = $fileDownload;

        return $this;
    }

    /**
     * Remove File Download
     *
     * @param \Blogger\BlogBundle\Entity\FTPDownload $fileDownload
     */
    public function removeFileDownload(\Blogger\BlogBundle\Entity\FTPDownload $fileDownload)
    {
        $this->userRoles->removeElement($fileDownload);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return UplFile
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set localname
     *
     * @param string $localname
     * @return UplFile
     */
    public function setLocalname($localname)
    {
        $this->localname = $localname;

        return $this;
    }

    /**
     * Get localname
     *
     * @return string 
     */
    public function getLocalname()
    {
        return $this->localname;
    }

    /**
     * Set localpath
     *
     * @param string $localpath
     * @return UplFile
     */
    public function setLocalpath($localpath)
    {
        $this->localpath = $localpath;

        return $this;
    }

    /**
     * Get localpath
     *
     * @return string 
     */
    public function getLocalpath()
    {
        return $this->localpath;
    }

    /**
     * Set oUser
     *
     * @param \Blogger\BlogBundle\Entity\User $oUser
     * @return UplFile
     */
    public function setOUser(\Blogger\BlogBundle\Entity\User $oUser = null)
    {
        $this->oUser = $oUser;

        return $this;
    }

    /**
     * Get oUser
     *
     * @return \Blogger\BlogBundle\Entity\User 
     */
    public function getOUser()
    {
        return $this->oUser;
    }

    protected function getUploadDir()
    {
        return 'uploadedFiles';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /*public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }*/
}
