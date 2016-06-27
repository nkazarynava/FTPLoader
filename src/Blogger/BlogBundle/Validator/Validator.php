<?php
namespace Blogger\BlogBundle\Validator;

use Symfony\Component\Config\Definition\Exception\Exception;
use Blogger\BlogBundle\Validator\ValidatorConfig;


 class Validator {

     private static $_instance;

     private $_aValidationFails;
     private $_aValidationSuccessLine;

     private function __construct() {

     }

     public static function getInstance() {
         if (empty(self::$_instance)){
             self::$_instance = new Validator();
         }
         return self::$_instance;
     }

     public function validate($aFileData) {

         $oFileData = new ComparedDataContainer($aFileData);
         $oReader = ValidationStringReader::getInstance();
         $aMappingArray = ValidatorConfig::RULE_NAME_CHECKER_CLASS_MAPPING;

         do {
             $aRulesData = $oReader->getRulesArrayFromCurrentLine();

             if ( $oReader->isEOF()) {
                 return false;
             }

             $oRulesData = new ComparedDataContainer($aRulesData);

             //check all rules in the current string of config file
             $bCheckResult = false;

             foreach ($aRulesData as $sRuleName => $sRuleValue) {

                 //it is never be the case
                 /*if (!isset($aMappingArray[$sRuleName])) {
                     throw new Exception('Wrong parameter in configuration file ('.ValidatorConfig::CONFIGURATION_FILE_PATH . ValidatorConfig::CONFIGURATION_FILE_NAME.') on line:' . $oReader->getCurrentLineNumber());
                 }*/
                 $sCheckerClassName = __NAMESPACE__."\\".$aMappingArray[$sRuleName];

                 if (!class_exists($sCheckerClassName)) {
                     throw new Exception("There is no no checker class defined for rule $sRuleName, needed class $sCheckerClassName");
                 }

                 $oChecker = new $sCheckerClassName($oFileData , $oRulesData);
                 $bCheckResult = $oChecker->check();

                 //validation failed - move to the next configuration file line
                 if (!$bCheckResult) {
                     //just for test
                     $this->_aValidationFails[$oReader->getCurrentLineNumber()] = $oChecker->getRuleName();
                     continue 2;
                 }
             }
             //just for test
             $this->_aValidationSuccessLine = $aRulesData;
             return true;

         } while (true);
     }

     //just for test
     public function getValidationFails() {
         return $this->_aValidationFails;
     }

     public function getValidationSuccessLine() {
         return $this->_aValidationSuccessLine;
     }
 }