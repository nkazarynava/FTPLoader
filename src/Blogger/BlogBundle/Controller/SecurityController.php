<?php
namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {

        //echo '<pre>';
        //var_dump($request);
        //echo '</pre>';

        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {

            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $session = $request->getSession();
            $error = (empty($session)?'': $session->get(Security::AUTHENTICATION_ERROR));
        }

        return $this->render('BloggerBlogBundle:Security:login.html.twig', array(
                               'last_username' => $this->get('request')->getSession()->get(Security::LAST_USERNAME),
                               'error' => $error ));
    }

    public function renderLoginFormAction() {

        if ($this->get('request')->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(Security::AUTHENTICATION_ERROR);
        }

        return $this->render('BloggerBlogBundle:Security:form.html.twig', array(
            'last_username' => $this->get('request')->getSession()->get(Security::LAST_USERNAME),
            'error' => $error ));
    }
}