<?php
	session_start();
	include('validateSignin.php');
	$PageTitle="Sign In";
	include('head.php');

	// registering a new user
	if (isset($_POST["register"])){
       $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'pareek', 'hello');

       //  get post data
       $name = $_POST["name"];
       $email = $_POST["email"];
       $password = $_POST["password"];
       $type = $_POST["user-type"];

       // hash and salt given password
       $hash = password_hash($password, PASSWORD_BCRYPT);

       $owner = 0;
       $driver = 0;
       // determine the binary value for user type
       if (strpos($type[0], 'owner') !== false || strpos($type[1], 'owner') !== false){
       	$owner = 1;
       }

       if (strpos($type[0], 'driver') !== false || strpos($type[1], 'driver') !== false){
       	$driver = 1;
       }

       // open db connection
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $result = $pdo->query("SELECT * FROM user where user.email = '$email' ");

       // if no results
       if($result->rowCount() != 0){
       	echo "<script>alert('Email already registered')</script>";
       }
       // new user registering
       else{
	       try{
	       	// sql query to insert into db
	        $sql = 'INSERT INTO user(name, email, driver, owner, password) VALUES(:name, :email, :driver, :owner, :password)';
	        $stmt = $pdo->prepare($sql);
	        $stmt->bindValue(':name', $name);
	        $stmt->bindValue(':email', $email);
	        $stmt->bindValue(':driver', $driver);
	        $stmt->bindValue(':owner', $owner);
	        $stmt->bindValue(':password', $hash);

			// print_r($sql);
	        $stmt->execute();
	       }
	       catch(PDOException $e){
	       	// echo $e->getMessage();
	       }
       }
	}
	// user wants to logout
	elseif (isset($_GET['logout'])) {
		// stop the session and destroy all variables
		session_unset();
		session_destroy();
		header("location: sign-in.php");
	}

?>

<!-- Body is a flex so header, and footer are at the top and bottom of pages -->
<body>
	<!-- Header to have a logo and my app name -->
    <?php
    include('signInNav.php');
    ?>
	<!-- Centering my signin box both vertically and horizontally -->
	<div class="centered">
		<div>
			<!-- Form which will go to the submit a spot page -->
			<form action="" onsubmit="validateSignIn(this)" method="post">
				<div class="registerBox" id="sign-in">
					<!-- Get email and password from user -->
					<h1>Sign In</h1>
					<label for="email"><b>Email</b></label><br>
					<input type="email" placeholder="Enter Email" id="email" name="email" required> <br>
					<label for="password"><b>Password</b></label><br>
					<input type="password" placeholder="Enter Password" id="password" name="password" required><br>
					<input type="submit" class="register-button" value="Sign In" name="signin">
				</div>
			</form>
		</div>
	</div>
	<?php
        include('footer.php');
    ?>
</body>
</html> 