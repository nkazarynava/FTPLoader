<?php
namespace Blogger\BlogBundle\Validator;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 6/26/2016
 * Time: 12:01
 */
class FileStopPhraseChecker {
    private static $_downloadedFileContents ;
    public function check() {
        $downloadedFile = $this->_oFileData->retrieveDataForCheckers($this);
        if (! $downloadedFile instanceof UploadedFile) {
              throw new Exception ("Wrong parameter for rule checker class FileStopPhraseChecker. For rule name "
                                   . $this->getRuleName() . " you should pass in file data object with type  Symfony\Component\HttpFoundation\File\UploadedFile");
        }

        if (empty(self::$_downloadedFileContents)) {
            self::$_downloadedFileContents = file_get_contents($downloadedFile->getRealPath());
        }

        $ruleSizeValue = $this->_oRulesConfigData->retrieveDataForCheckers($this);
        //return $fileSizeValue <= $ruleSizeValue;
    }
}