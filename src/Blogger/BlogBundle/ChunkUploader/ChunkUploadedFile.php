<?php
namespace Blogger\BlogBundle\ChunkUploader;
/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 6/30/2016
 * Time: 13:24
 */
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Blogger\BlogBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class ChunkUploadedFile {
    private $_oFileChunk;
    private $_fullFileName;
    private $_request;
    private $_bSavingError = false;
    private $_sJsonResponse;
    private $_sLocalSavePath;
    private $_oUser;
    public function __construct(Request $request, User $oUser, $sUploadsLocalPath ) {
        $request->files->get('file');
        $this->_oFileChunk =  $request->files->get('file');
        $this->_request = $request->request;
        $this->_fullFileName =  $this->_request->get('name' , $this->_oFileChunk->getClientOriginalName());
        $this->_fullFileSize = $this->_request->get('fullsize');
        $this->_sLocalSavePath = $sUploadsLocalPath;
        $this->_oUser = $oUser;
    }

    public function getFullFileClientName() {
        return $this->_fullFileName;
    }

    public function getFullFileClientSize() {
       return  $this->_fullFileSize;
    }

    public function getChunkSize() {
       return $this->_oFileChunk->getClientSize();
    }

    //start from 0
    public function getChunkNumber(){
        return $this->_request->get('chunk',0);
    }

    public function getChunksAmount() {
        return $this->_request->get('chunks',0);
    }

    public function getLocalChunkName() {
        return $this->_oUser->getUsername() . "_" . $this->_fullFileName;
    }

    public function getLocalSavePath() {
        return $this->_sLocalSavePath;
    }

    private function _getRealPathToTmpFile() {
        return $this->_oFileChunk->getRealPath();
    }

    //uploads_directory
    public function saveChunk() {
        $chunk = $this->getChunkNumber();
        $filePath = $this->getLocalSavePath() . $this->getLocalChunkName();
        $chunks = $this->getChunksAmount();

        $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
        if ($out) {
            // Read binary input stream and append it to temp file
            $in = @fopen($this->_getRealPathToTmpFile(), "rb");

            if ($in) {
                while ($buff = fread($in, 4096))
                    fwrite($out, $buff);
            } else {
                $this->_bSavingError = true;
                $this->_sJsonResponse = '{"OK": 0, "info": "Failed to open input stream."}';
                return;
            }


            @fclose($in);
            @fclose($out);

            @unlink($_FILES['file']['tmp_name']);
        } else {
            $this->_bSavingError = true;
            $this->_sJsonResponse = '{"OK": 0, "info": "Failed to open output stream."}';
            return;
        }

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);
        }
         $this->_sJsonResponse = '{"OK": 1, "info": "Upload successful."}';

    }

    public function isSaved(){
        return $this->_bSavingError;
    }
    public function getJsonResponse() {
        return $this->_sJsonResponse;
    }
}