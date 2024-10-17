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
use Aws\S3\MultipartCopy;
use Aws\S3\S3Client;

require __DIR__ . '/vendor/autoload.php';
$conf = require __DIR__ . '/config.php';


//$date = date('Ymd');
$bucket = $conf['bucket'];
$ftp_local_file=$argv[1];
$ftp_remote_file=$argv[2];
$ftp_path=$argv[3];


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

$s3Client = new Aws\S3\S3Client($opts);

$source = $ftp_local_file;

$uploader = new MultipartUploader($s3Client, $source, [
    'bucket' => $bucket,
    'key' => $conf['ftp_path']. $ftp_path .date('Y-m-d') . '/' . $ftp_remote_file,
     
]);

//Recover from errors
do {
    try {
        $result = $uploader->upload();
    } catch (MultipartUploadException $e) {
        $uploader = new MultipartUploader($s3Client, $source, [
            'state' => $e->getState(),
        ]);
    }
} while (!isset($result));

//Abort a multipart upload if failed
try {
    $result = $uploader->upload();
} catch (MultipartUploadException $e) {
    // State contains the "Bucket", "Key", and "UploadId"
    $params = $e->getState()->getId();
    $result = $s3Client->abortMultipartUpload($params);
}