<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\Entity\UplFile;
use Blogger\BlogBundle\Form\FileUploadType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Validator\ValidationStringReader;

use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    public function indexAction()
    {
       /*Test validation*/
        echo '<pre>';
        try {
            $oReader = ValidationStringReader::getInstance();
            $test = $oReader->getRulesArrayFromCurrentLine();
            var_dump($test);
        } catch (\Exception $e) {
            die ($e->getMessage());
        }



        echo '</pre>';
        die('end');

        return $this->render('BloggerBlogBundle:Page:index.html.twig');
    }

    public function downloadAction(Request $request)
    {
        //$test = new FileValidator();
        //die('controller');
        $file = new UplFile();
        $form = $this->createForm(FileUploadType::class, $file);
        //$form->handleRequest($request);
        //var_dump($file);
        //die('123');
        return $this->render('BloggerBlogBundle:Page:download.html.twig',
            array('form' => $form->createView(), 'error' => ''));

        //return $this->render('BloggerBlogBundle:Page:download.html.twig');
    }

   /* public function adminAction()
    {
        return $this->render('BloggerBlogBundle:Page:admin.html.twig');
    }*/
}