<?php
namespace Blogger\BlogBundle\Validator;

const RULE_EXT_NAME = 'ext';
const RULE_MAXSIZE_NAME = 'max';
const RULE_STOPW_NAME = 'stopwords';
const CONFIGURATION_FILE_PATH = '/../Resources/';
const CONFIGURATION_FILE_NAME = 'ValidatorConfig.csv';
const RULE_DELIMITER = ';';
const RULE_NAME_DELIMITER = ':';
const RULE_NAME_CHECKER_CLASS_MAPPING = array (
         RULE_EXT_NAME => 'fileTypeChecker',
         RULE_MAXSIZE_NAME => 'fileMaxSizeChecker',
         RULE_STOPW_NAME => 'fileStopPhraseChecker'
      );

class ValidationStringReader {

    private $_configurationFile;

    //private $_aRulesNamesCheckRuleClassMapping;

    private $_aRulesNames;

    private $_endFileMark = 'STOP';

    private static $_instance;

    public static function getInstance() {
        if (empty(self::$_instance)){
            self::$_instance = new ValidationStringReader();
        }
        return self::$_instance;
    }

    public function getRulesArrayFromCurrentLine() {
        $aRulesValues = $this->_parseNextRulesArray();
        if ($aRulesValues === $this->_endFileMark) {
            return false;
        }
        return $aRulesValues;
    }

    private function getConfigurationFilePath () {
        return __DIR__ . CONFIGURATION_FILE_PATH . CONFIGURATION_FILE_NAME;
    }

    private function __construct() {
        $this->_aRulesNames = array_keys(RULE_NAME_CHECKER_CLASS_MAPPING);
        try {
            $file = new \SplFileObject( $this->getConfigurationFilePath () );
            /*$file->setFlags(\SplFileObject::READ_CSV);
            $file->setFlags(\SplFileObject::SKIP_EMPTY);
            $file->setFlags(\SplFileObject::DROP_NEW_LINE);
            $file->setFlags(\SplFileObject::READ_AHEAD);*/
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
         if ($aRules ===  $this->_endFileMark)
             return $this->_endFileMark ;

         $explodeFunction = function($string) {
                $aRes = explode(RULE_NAME_DELIMITER, $string);
                $aRes = array_map("trim",$aRes);
                return $aRes;
             };

         $aRules = array_map($explodeFunction, $aRules);

         //check extension
         $sExtensionPattern = '/^\.[0-9a-z]{1,5}$/i';
         $aExtensionMatches = array();

         $aResult = array();
         foreach ($aRules as $aRule) {
              //test for extension conditions
              if (count($aRule) == 1) {
                  preg_match($sExtensionPattern, $aRule[0], $aExtensionMatches);
                  if (count($aExtensionMatches)) {
                      $aResult[RULE_EXT_NAME] = $aRule[0];
                  }
                  continue;
              }
             $aResult[$aRule[0]] = $aRule[1];
         }

         $aResult = array_intersect_key($aResult, RULE_NAME_CHECKER_CLASS_MAPPING);
         return $aResult;
    }

    private function _readNextRulesLineToArray () {

        if ($this->_configurationFile->eof())
            return $this->_endFileMark ;

        //skip empty or ?? invalid lines
        $aResult = $this->_configurationFile->fgetcsv(RULE_DELIMITER);

        while (empty($aResult) || is_array($aResult) && empty($aResult[0])) {
            if ($this->_configurationFile->eof())
                return $this->_endFileMark;
            $aResult = $this->_configurationFile->fgetcsv(RULE_DELIMITER);
        }

        return  $aResult;
    }
}