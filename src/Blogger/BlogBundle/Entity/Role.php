<?php
namespace Blogger\BlogBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class Role implements RoleInterface
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
     * @ORM\Column(type="string", length=255)
     *
     * @var string $name
     */
    protected $name;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     *
     * @var DateTime $createdAt
     */
    protected $createdAt;

    /**
     * ?????? ??? id.
     *
     * @return integer The id.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * ?????? ??? ???????? ????.
     *
     * @return string The name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * ?????? ??? ???????? ????.
     *
     * @param string $value The name.
     */
    public function setName($value)
    {
        $this->name = $value;
    }

    /**
     * ?????? ??? ???? ???????? ????.
     *
     * @return DateTime A DateTime object.
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * ??????????? ??????
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     *
     * @return string The role.
     */
    public function getRole()
    {
        return $this->getName();
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Role
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
