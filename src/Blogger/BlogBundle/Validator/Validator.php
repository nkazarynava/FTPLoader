<?php
namespace Blogger\BlogBundle\Validator;

/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 6/25/2016
 * Time: 19:48
 */

 class Validator {

     private static $_instance;

     private function __construct() {

     }

     public function getInstance() {
         if (empty(self::$_instance)){
             self::$_instance = new Validator();
         }
         return self::$_instance;
     }

     public static function validate($aFileData) {
         $oFileData = new ComparedDataContainer($aFileData);
     }

     private function _validate() {

     }
 }