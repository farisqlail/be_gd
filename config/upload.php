<?php

return [
    'max_file_size' => env('PHP_INI_UPLOAD_MAX_FILESIZE', '20M'), // default to 2MB if not set in .env
];
