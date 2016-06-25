<?php
namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Entity\ServerRepository")
 * @ORM\Table(name="ftp_servers",uniqueConstraints={
 *     @ORM\UniqueConstraint(name="server_idx", columns={"ip_address", "save_path"})})
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Entity\ServerRepository")
 */

class FtpServer
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
     * @ORM\Column(type="string", length=25)
     *
     * @var string $type
     */
    protected $type;


    /**
     * @ORM\Column(type="string", length=25, name="ip_address")
     *
     * @var string $ipAddr
     */
    protected $ipAddr;

    /**
     * @ORM\Column(type="string", length=255, name="save_path")
     *
     * @var string $savePath
     */
    protected $savePath;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct() {
        $this->isActive = true;
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
     * Set type
     *
     * @param string $type
     * @return FtpServer
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set ipAddr
     *
     * @param string $ipAddr
     * @return FtpServer
     */
    public function setIpAddr($ipAddr)
    {
        $this->ipAddr = $ipAddr;

        return $this;
    }

    /**
     * Get ipAddr
     *
     * @return string 
     */
    public function getIpAddr()
    {
        return $this->ipAddr;
    }

    /**
     * Set savePath
     *
     * @param string $savePath
     * @return FtpServer
     */
    public function setSavePath($savePath)
    {
        $this->savePath = $savePath;

        return $this;
    }

    /**
     * Get savePath
     *
     * @return string 
     */
    public function getSavePath()
    {
        return $this->savePath;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return FtpServer
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
