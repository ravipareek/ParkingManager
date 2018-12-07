<?php
	use Aws\S3\S3Client;
	use Aws\Credentials\CredentialProvider;
	use Aws\S3\Exception\S3Exception;
	use Aws\Exception\AwsException;


	// location of credential files

  	putenv('HOME=/var/www/4ww3');
	require 'vendor/autoload.php';
	// creating the s3 client with information
	try{
		$s3 = S3Client::factory(array(
			'region' => 'us-east-2',
			'version' => 'latest',
			'profile' => 'default'
		));
	}catch(Exception $e){
		// echo $e;
	}
	// echo "S3";
?>