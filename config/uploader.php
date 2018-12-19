<?php

return [
    'base_path' => public_path(),
    'upload_path' => env('UPLOADS_DIR', 'uploads'),
    'auto_delete_attachments' => true,
];
