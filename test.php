<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/vendor/autoload.php';
use Aws\S3\S3Client;

$client = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'fra1',
    'endpoint' => 'https://fra1.digitaloceanspaces.com',
    //'signature_version' => 'v4-unsigned-body',
    'credentials' => [
        'key'    => "FWM4MO75KONTL2U4WU7J",
        'secret' => "9Ribz39COCQ8uy9c0hQnHWnxYV/ePmjhOomeHphmYww",
    ],
]);

/*
$response = $client->createBucket([
    'Bucket' => 'web-ibu',
]);

print_r($response); */

$spaces = $client->listBuckets();
foreach($spaces['Buckets'] as  $space){
  echo $space['Name']."\n";
}

$response = $client->putObject([
    'Bucket' => 'cdn.rentacar.ba',
    'Key'    => 'tesla123.jpg',
    'Body'   => 'The contents of the file.',
    'ACL'    => 'public-read'
]);

print_r($response);

?>
