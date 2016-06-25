<?php
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

    public function retrieveDataForCheckers(\RuleChecker $oChecker) {
        return $this->_getValueByName($oChecker->getRuleName());
    }

    private function _getValueByName($sName) {
        return isset($this->_aData[$sName]) ? $this->_aData[$sName] : false;
    }
}