<?php
namespace \Blogger\BlogBundle\Validator;
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 6/25/2016
 * Time: 19:38
 */
class fileTypeChecker extends \RuleCheckerAbstract {
    public function check() {
        $fileValue = $this->_oFileData->retrieveDataForCheckers($this);
        $ruleValue = $this->_oRulesConfigData->retrieveDataForCheckers($this);

        return $fileValue === $ruleValue;
    }
}