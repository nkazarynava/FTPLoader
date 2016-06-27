<?php
namespace Blogger\BlogBundle\Validator;

use Blogger\BlogBundle\Validator\ValidatorConfig;
use Blogger\BlogBundle\Validator\RuleCheckerInterface;
use Blogger\BlogBundle\Validator\ComparedDataContainer;
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 6/25/2016
 * Time: 18:26
 */

 abstract class RuleCheckerAbstract implements RuleCheckerInterface {
     protected $_oFileData;
     protected $_oRulesConfigData;
     protected $_sRuleName;

     public function __construct (ComparedDataContainer $oFileData, ComparedDataContainer $oRulesConfigData) {
         $this->_oFileData = $oFileData;
         $this->_oRulesConfigData = $oRulesConfigData;
         $this->_sRuleName = $this->_retrieveRuleNameFromConstant();
     }

     public function getRuleName() {
         return $this->_sRuleName;
     }

     private function _retrieveRuleNameFromConstant() {
         $sClassName = get_class($this);
         $oReflection = new \ReflectionClass($sClassName);
         $sClassName = $oReflection->getShortName();
         $aNameMapping = ValidatorConfig::RULE_NAME_CHECKER_CLASS_MAPPING;
         $aClassNameMapping = array_flip($aNameMapping);
         return isset($aClassNameMapping[$sClassName]) ? $aClassNameMapping[$sClassName] : false;
     }

     public abstract function check();
 }