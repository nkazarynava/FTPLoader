<?php
namespace Blogger\BlogBundle\Validator;
use Blogger\BlogBundle\Validator\RuleCheckerAbstract;
/**
* Created by PhpStorm.
* User: Natalia
* Date: 6/25/2016
* Time: 19:38
*/
class FileMaxSizeChecker extends RuleCheckerAbstract {
    public function check() {
        $fileSizeValue = $this->_oFileData->retrieveDataForCheckers($this);
        $ruleSizeValue = $this->_oRulesConfigData->retrieveDataForCheckers($this);
        //in future: add compared values validation
        return $fileSizeValue <= $ruleSizeValue;
    }

    private function _validateValues() {

    }
}
