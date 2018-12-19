<?php

function uploads_path($path = '')
{
    return DIRECTORY_SEPARATOR. get_config('uploader.upload_path') . ($path ? DIRECTORY_SEPARATOR.$path : $path);
}

function uploads_full_path($path = '')
{
    return get_config('uploader.base_path') . uploads_path($path);
}

function get_config($key)
{
    $config = app('config');

    if (is_null($config[$key])) {
        $config->set('uploader', require __DIR__ . '/../config/uploader.php');
    }

    return $config[$key];
}
