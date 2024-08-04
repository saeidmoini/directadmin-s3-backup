<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2018 Power Kernel
 */

/* @var $ftp_local_file string $argv[1] */

/* @var $ftp_remote_file string $argv[2] */

use Aws\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;

require __DIR__ . '/vendor/autoload.php';
$conf = require __DIR__ . '/config.php';

//$date = date('Ymd');
$bucket = $conf['bucket'];
$ftp_local_file=$argv[1];
$ftp_remote_file=$argv[2];


// S3 Client
$opts = [
    'version' => 'latest',
    'region' => $conf['region'],
    'credentials' => $conf['credentials'],
    'use_path_style_endpoint' => true

];
if (!empty($conf['endpoint'])) {
    $opts['endpoint'] = $conf['endpoint'];
}

$client = new Aws\S3\S3Client($opts);

// Upload
$uploader = new MultipartUploader($client, $ftp_local_file, [
    'bucket' => $bucket,
    'key' => $conf['ftp_path']. '/' .date('Y-m-d') . '/' . $ftp_remote_file,
]);

try {
    $result = $uploader->upload();
    echo "Upload complete: {$result['ObjectURL']}\n";
} catch (MultipartUploadException $e) {
    echo $e->getMessage() . "\n";
}
