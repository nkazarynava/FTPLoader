<?php
namespace Blogger\BlogBundle\Validator;
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 6/26/2016
 * Time: 18:07
 */

class ValidatorConfig {
    const RULE_EXT_NAME = 'ext';
    const RULE_MAXSIZE_NAME = 'max';
    const RULE_STOPW_NAME = 'stopwords';
    const CONFIGURATION_FILE_PATH = '/../Resources/';
    const CONFIGURATION_FILE_NAME = 'ValidatorConfig.csv';
    const RULE_DELIMITER = ';';
    const RULE_NAME_DELIMITER = ':';
    const RULE_NAME_CHECKER_CLASS_MAPPING = array (
        self::RULE_EXT_NAME => 'FileTypeChecker',
        self::RULE_MAXSIZE_NAME => 'FileMaxSizeChecker',
        self::RULE_STOPW_NAME => 'FileStopPhraseChecker'
    );

}