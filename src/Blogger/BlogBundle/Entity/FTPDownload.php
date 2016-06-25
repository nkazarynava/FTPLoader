<?php
namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Entity\FTPDownloadsRepository")
 * @ORM\Table(name="ftp_downloads")
 */
class FTPDownload
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", name="load_date")
     *
     * @var DateTime $loadDate
     */
    protected $loadDate;

    /**
     * @ORM\ManyToOne(targetEntity="FtpServer")
     * @ORM\JoinColumn(name="server_id", referencedColumnName="id" )
     */
     protected $oServer;

    /**
     * @ORM\ManyToOne(targetEntity="UplFile", inversedBy="fileDownloads")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id")
     */
     protected $oFile;
     /**
      * @ORM\Column(type="string", length=25)
      */
     private $status;

     public function __construct() {
        $this->loadDate = new \DateTime();
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
     * Set loadDate
     *
     * @param \DateTime $loadDate
     * @return FTPDownload
     */
    public function setLoadDate($loadDate)
    {
        $this->loadDate = $loadDate;

        return $this;
    }

    /**
     * Get loadDate
     *
     * @return \DateTime 
     */
    public function getLoadDate()
    {
        return $this->loadDate;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return FTPDownload
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set oServer
     *
     * @param \Blogger\BlogBundle\Entity\FtpServer $oServer
     * @return FTPDownload
     */
    public function setOServer(\Blogger\BlogBundle\Entity\FtpServer $oServer = null)
    {
        $this->oServer = $oServer;

        return $this;
    }

    /**
     * Get oServer
     *
     * @return \Blogger\BlogBundle\Entity\FtpServer 
     */
    public function getOServer()
    {
        return $this->oServer;
    }

    /**
     * Set oFile
     *
     * @param \Blogger\BlogBundle\Entity\UplFile $oFile
     * @return FTPDownload
     */
    public function setOFile(\Blogger\BlogBundle\Entity\UplFile $oFile = null)
    {
        $this->oFile = $oFile;

        return $this;
    }

    /**
     * Get oFile
     *
     * @return \Blogger\BlogBundle\Entity\UplFile 
     */
    public function getOFile()
    {
        return $this->oFile;
    }
}
