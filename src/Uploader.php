<?php

namespace Maloshtanov\Uploader;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

use Webpatser\Uuid\Uuid;

/*
 * Service for storing uploaded files into hash-boxes.
 * Example file path :
 *                                                ___ original file ext
 *                                               /
 *        |------------ uuid -----------------| |-|
 *    /d3d/d3d29d70-1d25-11e3-8591-034165a3a613.png
 *    |---|
 *      \______ hash box taken from first three letters of uuid
 *
 * Total amount of has-boxes is 16*16*16 = 4096
 *
 */

class Uploader
{
    protected $basePath;

    protected $uploadPth;

    /**
     * Uploader constructor.
     * @param array  $config
     */
    public function __construct($config)
    {
        $this->basePath = $config['base_path'];
        $this->uploadPath = $config['upload_path'];
    }

    /**
     * @param string  $uploadPath
     * @return $this
     */
    public function to($uploadPath)
    {
        $this->uploadPath = $uploadPath;

        return $this;
    }

    /**
     * @param array|string|\Illuminate\Http\Request|\Illuminate\Http\UploadedFile|null  $input
     * @return array|string|false
     */
    public function upload($input = null)
    {
        $urls = [];

        if ($input instanceof \Request) {
            $files = $input->allFiles();

        } elseif ($input instanceof UploadedFile) {
            $files = [$input];

        } elseif (is_string($input) && $file = \Request::file($input)) {
            $files = [$file];

        } elseif (is_array($input)) {
            $files = $input;

        } else {
            $files = \Request::allFiles();
        }

        foreach ($files as $file) {
            // generate uniq path for this file
            [$uuid, $box] = $this->generatePair();

            $pathName = "$this->uploadPath/$box";
            $fileName = "$uuid.".$file->getClientOriginalExtension();

            if (!$file->move("$this->basePath/$pathName", $fileName)) {
                return false;
            }

            $urls[] = "/$pathName/$fileName";
        }

        if (count($urls) === 1) {
            $urls = $urls[0];

        } elseif (count($urls) === 0) {
            $urls = false;
        }

        return $urls;
    }

    /**
     * @param array|string  $files
     * @return bool
     */
    public function delete($files)
    {
        if (is_string($files)) {
            $files = [$files];

        } elseif (!is_array($files)) {
            return false;
        }

        foreach ($files as $file) {
            $path = realpath("$this->basePath/$file");

            if (file_exists($path) && is_file($path)) {
                unlink($path);
            }
        }

        return true;
    }

    /**
     * @return array
     */
    private function generatePair()
    {
        $uuid = Uuid::generate();
        $box = substr($uuid, 0, 3);
        return [$uuid, $box];
    }
}
