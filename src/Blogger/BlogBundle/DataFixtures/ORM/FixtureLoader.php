<?php
namespace Blogger\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Blogger\BlogBundle\Entity\User;
use Blogger\BlogBundle\Entity\Role;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class FixtureLoader implements FixtureInterface
{
    public function load( ObjectManager $manager)
    {
        // ???????? ???? ROLE_ADMIN
        $role = new Role();
        $role->setName('ROLE_ADMIN');

        $role1 = new Role();
        $role1->setName('ROLE_USER');

         $manager->persist($role);
        $manager->persist($role1);
         // ???????? ????????????
         $user = new User();
         $user->setUsername('admin');
         $user->setEmail('john@example.com');
         $user->setIsActive(true);
         //$user->setSalt(md5(time()));

         // ??????? ? ????????????? ?????? ??? ????????????,
         // ??? ????????? ????????? ? ????????????????? ???????
         $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
         $password = $encoder->encodePassword('admin', $user->getSalt());
         $user->setPassword($password);

         $user->getUserRoles()->add($role);

         $manager->persist($user);
         $manager->flush();
    }
}