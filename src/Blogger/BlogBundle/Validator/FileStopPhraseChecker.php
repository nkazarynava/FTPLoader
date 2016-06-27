<?php
namespace Blogger\BlogBundle\Validator;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Blogger\BlogBundle\Validator\RuleCheckerAbstract;
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 6/26/2016
 * Time: 12:01
 */
class FileStopPhraseChecker  extends RuleCheckerAbstract {

    public function check() {
        $downloadedFile = $this->_oFileData->retrieveDataForCheckers($this);
        if (! $downloadedFile instanceof UploadedFile) {
              throw new Exception ("Wrong parameter for rule checker class FileStopPhraseChecker. For rule name "
                                   . $this->getRuleName() . " you should pass object with type  Symfony\Component\HttpFoundation\File\UploadedFile");
        }

        //just read the file line by line and check foe stop word
        $sStopWord = $this->_oRulesConfigData->retrieveDataForCheckers($this);
        $handle = fopen($downloadedFile->getRealPath(), 'r');
        $bValid = true;
        while (($buffer = fgets($handle)) !== false) {
            if (strpos($buffer, $sStopWord) !== false) {
                $bValid = false;
                break;
            }
        }
        fclose($handle);
        return $bValid;
    }
}