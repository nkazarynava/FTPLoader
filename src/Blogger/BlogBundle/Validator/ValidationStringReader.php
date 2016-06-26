<?php
namespace Blogger\BlogBundle\Validator;
use Blogger\BlogBundle\Validator\ValidatorConfig;

class ValidationStringReader {

    private $_configurationFile;

    private $_currentLineNmr = 0;

    private $_aRulesNames;

    //private $_endFileMark = 'STOP';
    private $_isEOF = false;
    private static $_instance;

    public static function getInstance() {
        if (empty(self::$_instance)){
            self::$_instance = new ValidationStringReader();
        }
        return self::$_instance;
    }

    public function isEOF(){
        return $this->_isEOF;
    }

    public function getRulesArrayFromCurrentLine() {
        $aRulesValues = $this->_parseNextRulesArray();
        if ($this->_isEOF)
            return;
        return $aRulesValues;
    }

    public function getCurrentLineNumber() {
        return $this->_currentLineNmr;
    }

    private function getConfigurationFilePath () {
        return __DIR__ . ValidatorConfig::CONFIGURATION_FILE_PATH . ValidatorConfig::CONFIGURATION_FILE_NAME;
    }

    private function __construct() {
        $this->_aRulesNames = array_keys( ValidatorConfig::RULE_NAME_CHECKER_CLASS_MAPPING);
        try {
            $file = new \SplFileObject( $this->getConfigurationFilePath () );
            $this->_configurationFile = $file;
        } catch (\Exception $e) {;
            die($e->getMessage());
        }
    }

    /*
     * @var form  checkers array  like array (  array ( "name" => "value") , array ("name1" =>" value1"))
     * form  strings array like array ( "name : value", "name1 : value1" )
     */
    private function _parseNextRulesArray() {
         $aRules = $this->_readNextRulesLineToArray ();// explode(CHECKER_NAME_DELIMITER,);

         //all validation configuration file has been read
         if ($this->_isEOF)
             return;

         /*$explodeFunction = function($string) {
                $aRes = explode(RULE_NAME_DELIMITER, $string);
                $aRes = array_map("trim",$aRes);
                return $aRes;
             };

         $aRules = array_map($explodeFunction, $aRules);*/
         foreach ($aRules as $key => &$sValue) {
             $aRuleData = explode(ValidatorConfig::RULE_NAME_DELIMITER, $sValue);
             $sValue = array_map("trim", $aRuleData);
         }

         //check extension
         $sExtensionPattern = '/^\.[0-9a-z]{1,5}$/i';
         $aExtensionMatches = array();

         $aResult = array();
         foreach ($aRules as $aRule) {
              //test for extension conditions
              if (count($aRule) == 1) {
                  preg_match($sExtensionPattern, $aRule[0], $aExtensionMatches);
                  if (count($aExtensionMatches)) {
                      $aResult[ValidatorConfig::RULE_EXT_NAME] = $aRule[0];
                  }
                  continue;
              }
             $aResult[$aRule[0]] = $aRule[1];
         }

         $aResult = array_intersect_key($aResult, ValidatorConfig::RULE_NAME_CHECKER_CLASS_MAPPING);
         return $aResult;
    }

    private function _readNextRulesLineToArray () {

        if ($this->_configurationFile->eof()){
            $this->_isEOF = true;
            return;// $this->_endFileMark ;
        }


        $this->_currentLineNmr++;
        $aResult = $this->_configurationFile->fgetcsv(ValidatorConfig::RULE_DELIMITER);

        //skip empty lines
        while ( is_array($aResult) && is_null($aResult[0])) {

            if ($this->_configurationFile->eof()) {
                $this->_isEOF = true;
                return;
            }
                //return $this->_endFileMark;

            $this->_currentLineNmr++;
            $aResult = $this->_configurationFile->fgetcsv(ValidatorConfig::RULE_DELIMITER);
        }

        return  $aResult;
    }
}