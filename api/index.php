<?php

/**
 * Entrypoint Serverless untuk Vercel.
 * Vercel Serverless Function mengarahkan seluruh HTTP request ke berkas ini.
 */

// Siapkan direktori storage & cache di /tmp (lokasi writable pada Vercel AWS Lambda container)
$storageDirs = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/views',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Teruskan penanganan request ke public/index.php bawaan Laravel
require __DIR__ . '/../public/index.php';
