<?php
	use Aws\S3\S3Client;
	use Aws\Credentials\CredentialProvider;
	use Aws\S3\Exception\S3Exception;
	use Aws\Exception\AwsException;



	// error_reporting(E_ALL);
 //  	ini_set('display_errors', 1);

  	putenv('HOME=/var/www/4ww3');
	require 'vendor/autoload.php';
	// $config = require('config.php');
	// echo "Init AWS 		";


	try{
		$s3 = S3Client::factory(array(
			'region' => 'us-east-2',
			'version' => 'latest',
			'profile' => 'default'
		));
	}catch(Exception $e){
		echo $e;
	}
	// echo "S3";
?>