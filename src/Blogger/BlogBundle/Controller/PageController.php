<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\Entity\UplFile;
use Blogger\BlogBundle\Form\FileUploadType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Validator\Validator;
use Blogger\BlogBundle\Validator\ValidatorConfig;

use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('BloggerBlogBundle:Page:index.html.twig');
    }

    public function downloadAction(Request $request)
    {
        //$test = new FileValidator();
        //die('controller');
        $file = new UplFile();
        $form = $this->createForm(FileUploadType::class, $file);
        $form->handleRequest($request);
         $sError = '';
        if ($form->isSubmitted() && $form->isValid()) {

            $sExt =  $file->filePointer->getClientOriginalExtension();
           // $sExt =  $file->filePointer->guessExtension();
            $aFileData = array (
                ValidatorConfig::RULE_EXT_NAME  => '.' . $sExt,
                ValidatorConfig::RULE_MAXSIZE_NAME =>  $file->filePointer->getClientSize(),
                ValidatorConfig::RULE_STOPW_NAME =>  $file->filePointer
            );

            $oValidator = Validator::getInstance();
            echo '<pre>';
            $bResult = $oValidator->validate($aFileData);

            echo 'FAILS: </br>';
            $aFails = $oValidator->getValidationFails();
            var_dump($aFails);
            echo 'SUCCESS: </br>';
            $aSuccessLine = $oValidator->getValidationSuccessLine();
            var_dump($aSuccessLine);
            echo '</pre>';
            if (!$bResult) {
                echo 'INVALID';
            }
            echo "VALID";
            die('test');
        }
        return $this->render('BloggerBlogBundle:Page:download.html.twig',
            array('form' => $form->createView(), 'error' => ''));

    }

   /* public function adminAction()
    {
        return $this->render('BloggerBlogBundle:Page:admin.html.twig');
    }*/
}