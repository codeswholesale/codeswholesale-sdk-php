<?php


namespace CodesWholesale\Util;


use CodesWholesale\Resource\Code;

class CodeImageWriter {
    /**
     *
     *
     * @param Code $code
     * @param String $whereToSaveDirectory
     * @param String $fileName
     * @throws \InvalidArgumentException
     */
    public static function write(Code $code, $whereToSaveDirectory, $fileName = null) {

        if(!$code->isImage()) {
            throw new \InvalidArgumentException("Given code is not image code type.");
        }

        if (!file_exists($whereToSaveDirectory)) {
            mkdir($whereToSaveDirectory, 0755, true);
        }

        if($fileName) {
            $whereToSaveDirectory .= "/" . $fileName;
        } else {
            $whereToSaveDirectory .= "/" . $code->getFileName();
        }

        $imageData = base64_decode($code->getCode());
        $success = file_put_contents($whereToSaveDirectory, $imageData);

        return $whereToSaveDirectory;
    }
} 