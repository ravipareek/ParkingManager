<?php
$PageTitle="Sign In";
function customPageHeader(){?>
<meta name="mobile-web-app-capable" content="yes">
<!-- Mobile Home Screen App -->
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="#33a5ff" />

<link rel="apple-touch-icon" sizes="180x180" href="res/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="res/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="res/favicon-16x16.png">
<link rel="manifest" href="site.webmanifest">
<link rel="mask-icon" href="res/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="res/favicon.ico">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="res/browserconfig.xml">
<meta name="theme-color" content="#33a5ff">
<?php }
include('head.php');
?>

<!-- Body is a flex so header, and footer are at the top and bottom of pages -->
<body>
	<!-- Header to have a logo and my app name -->
	<?php
    include('signInNav.php');
    ?>
	<!-- Centering my signin box both vertically and horizontally -->
	<div class="centered">
		<!-- Form which will go to the submit a spot page -->
		<form  action="sign-in.php" onsubmit="return validateRegister(this)" method="post">
			<div class="registerBox">
				<!-- Get name, email, password, confirm the password and what type of user they are -->
				<h1>Register</h1>
				<label for="name"><b>Name</b></label><br>
				<input type="text" placeholder="Enter Full Name" id="name" name="name" required> <br>
				<label for="email"><b>Email</b></label><br>
				<input type="email" placeholder="Enter Email" id="email" name="email" required> <br>
				<label for="password"><b>Password</b></label><br>
				<input type="password" placeholder="Enter Password" id="password" name="password" required><br>
				<label for="password-repeat"><b>Repeat Password</b></label><br>
				<input type="password" placeholder="Repeat Password" id="password-repeat" name="password-repeat" required><br>
				<input type="checkbox" name="user-type[]" value="owner">I am a parking lot owner<br>
				<input type="checkbox" name="user-type[]" value="driver">I am a driver<br>
				<input type="submit" class="register-button" value="Register" name="register"><br>
				<!-- Way to sign in if already have an account -->
				<div id="existingAccount">
					<label ><b>Already have an account?</b></label> <br>
					<a href="sign-in.php" title="Sign in">Sign in</a>
				</div>
			</div>
		</form>
	</div>
	<?php
        include('footer.php');
    ?>
</body>
</html> 