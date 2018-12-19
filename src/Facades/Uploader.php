<?php
namespace Maloshtanov\Uploader\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static Uploader to(string $uploadPath)
 * @method static mixed upload(array|string|\Illuminate\Http\Request|\Illuminate\Http\UploadedFile|null $input = null)
 * @method static bool delete(array|string $files)
 *
 * @see \Maloshtanov\Uploader\Uploader
 */
class Uploader extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() : string
    {
        return \Maloshtanov\Uploader\Uploader::class;
    }
}
