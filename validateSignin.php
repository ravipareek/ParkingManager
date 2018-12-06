<?php
session_start();
if (isset($_POST["signin"])){
		try{
	        $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'pareek', 'hello');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$email = $_POST['email'];
			$password = $_POST['password'];

			// print_r("Reached");
			$result = $pdo->query("SELECT * from user where email = '$email'");
			// print_r($result->fetchAll());
			foreach ($result as $ROW) {
				$hashPassword = $ROW['password'];
				if (password_verify($password,$hashPassword)){
					// successful signin
					header("location: search.php");
					$_SESSION['valid'] = true;
					$_SESSION['username'] = $email;
					$_SESSION['uid'] = $ROW['uid'];
				}
				else{
					// print_r("not found");
					echo "<script>alert('Email and Password combination not found')</script>";
					sleep(1);
					// header("location: sign-in.php");
				}
			}
		} catch(PDOExeption $e){
			echo $e->getMessage();
		}
	}	
?>