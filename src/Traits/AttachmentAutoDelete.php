<?php

namespace Maloshtanov\Uploader\Traits;

trait AttachmentAutoDelete
{
    /**
     * Boot up the trait
     */
    public static function bootAttachmentAutoDelete()
    {
        static::updating(function ($model) {
            $model->autoDelete(
                array_only($model->getDirty(), $model->attachmentFields)
            );
        });

        static::deleting(function ($model) {
            $model->autoDelete(
                $model->only($model->attachmentFields)
            );
        });
    }


    /**
     * Auto delete attachment handler
     *
     * @param array  $fields
     */
    protected function autoDelete(array $fields)
    {
        if (property_exists($this, 'attachmentFields') && get_config('uploader.auto_delete_attachments')) {
            \Uploader::delete(array_values($fields));
        }
    }
}
