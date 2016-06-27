<?php
namespace Blogger\BlogBundle\Validator;
use Blogger\BlogBundle\Validator\RuleCheckerInterface;
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 6/25/2016
 * Time: 18:35
 */
class ComparedDataContainer {
    private $_aData;

    public function __construct($aData) {
        $this->_aData = $aData;
    }

    public function retrieveDataForCheckers(RuleCheckerInterface $oChecker) {
        return $this->_getValueByName($oChecker->getRuleName());
    }

    private function _getValueByName($sName) {
        if (!isset ($this->_aData[$sName])) {
            return false;
        }
        return isset($this->_aData[$sName]) ? $this->_aData[$sName] : false;
    }

    /*public function setData($aData) {
        $this->_aData = $aData;
    }*/
}