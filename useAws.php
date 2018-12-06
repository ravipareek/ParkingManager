<?php
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;


	require 'vendor/autoload.php';
	$config = require('config.php');
	// echo "Init AWS";
	try{
		$s3 = S3Client::factory(array(
			'region' => 'us-east-2',
			'version' => 'latest',
			'credentials' => array(
				'key' => 'AKIAIIVMFZGFDBJWHYUQ',
				'secret' => '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'
			)
		));
	}catch(Exception $e){
		echo $e;
	}
	// echo "S3 ";
?>