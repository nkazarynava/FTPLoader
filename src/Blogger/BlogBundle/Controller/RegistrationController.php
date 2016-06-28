<?php
namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\Form\UserType;
use Blogger\BlogBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class RegistrationController extends Controller
{
    public function registerAction(Request $request)
    {
         // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        $sErrorMsg = '';
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            //trying to save USER_ROLE
            $role = $this->getDoctrine()
                ->getRepository('BloggerBlogBundle:Role')
                ->find(3); // Finds "ROLE_USER"

            $user->getUserRoles()->add($role);

            $em = $this->getDoctrine()->getManager();


            /*
             *
             * $user = new User('login');
$presentUsers = $em->getRepository('MyProject\Domain\User')->findBy(array('login' => 'login'));
if (count($presentUsers)>0) {
    // this login is already taken (throw exception)
}
             *
             */
            // 4) save the User!
            try {

                $em->persist($user);
                $em->flush();

            } catch ( \Exception $e) {

                if ($e instanceof UniqueConstraintViolationException) {

                    $sMessage = ' '.$e->getMessage();
                    $sName = $user->getUsername();
                    $sEmail = $user->getEmail();

                    $sErrorMsg = 'User with {} already exists. Please try another one.';
                    if (!(stripos($sMessage, 'Duplicate entry'.' \'' .$sName) === false) ) {
                        $sErrorMsg = str_replace('{}','name '. $sName);
                    } else {
                        $sErrorMsg = str_replace('{}','email '. $sEmail);
                    }

                } else {
                    $sErrorMsg = 'Smth went wrong. try again later.';
                }

                return $this->render('BloggerBlogBundle:Page:register.html.twig',
                    array('form' => $form->createView(), 'error' => $sErrorMsg));
            }//catch

            return $this->redirectToRoute('BloggerBlogBundle_about');
        }

        return $this->render('BloggerBlogBundle:Page:register.html.twig',
            array('form' => $form->createView(), 'error' => $sErrorMsg));
    }
}