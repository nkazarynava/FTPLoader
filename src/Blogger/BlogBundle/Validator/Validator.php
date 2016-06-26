<?php
namespace Blogger\BlogBundle\Validator;

use Symfony\Component\Config\Definition\Exception\Exception;
use Blogger\BlogBundle\Validator\ValidatorConfig;


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

                 if (!isset($aMappingArray[$sRuleName])) {
                     throw new Exception('Wrong parameter in configuration file ('.ValidatorConfig::CONFIGURATION_FILE_PATH . ValidatorConfig::CONFIGURATION_FILE_NAME.') on line:' . $oReader->getCurrentLineNumber());
                 }
                 $sCheckerClassName = $aMappingArray[$sRuleName];

                 if (!class_exists($sCheckerClassName)) {
                     throw new Exception("There is no no checker class defined for rule $sRuleName, needed class $sCheckerClassName");
                 }
                   //  continue;
                 $oChecker = new $sCheckerClassName($oFileData , $oRulesData);
                 $bCheckResult = $oChecker->check();

                 //validation failed - move to the next configuration file line
                 if (!$bCheckResult) continue 2;
             }

             return true;

         } while (true);

     }
 }