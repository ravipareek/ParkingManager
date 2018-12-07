<?php
session_start();
// the post name was signin
if (isset($_POST["signin"])){
		try{
			// open db
	        $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'pareek', 'hello');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// get post info
			$email = $_POST['email'];
			$password = $_POST['password'];

			// get info based on email
			$result = $pdo->query("SELECT * from user where email = '$email'");

			// go through all data returned
			foreach ($result as $ROW) {
				// get the hashed password stored
				$hashPassword = $ROW['password'];
				// verify the password
				if (password_verify($password,$hashPassword)){
					// successful signin
					header("location: search.php");
					$_SESSION['valid'] = true;
					$_SESSION['username'] = $email;
					$_SESSION['uid'] = $ROW['uid'];
				}
				// wrong password
				else{
					// print_r("not found");
					echo "<script>alert('Email and Password combination not found')</script>";
					sleep(1);
					// header("location: sign-in.php");
				}
			}
		} catch(PDOExeption $e){
			// echo $e->getMessage();
		}
	}	
?>