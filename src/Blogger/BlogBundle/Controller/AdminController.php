<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        /*$oUser = $this->getUser();
        $Roles = $oUser->getUserRoles()->toArray();
        $oRole = $Roles[0];
        echo '<pre>';
        var_dump($oRole);
        echo '</pre>';
        die('123');*/
        return $this->render('BloggerBlogBundle:Admin:index.html.twig');
    }
}