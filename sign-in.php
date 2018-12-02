<?php
$PageTitle="Sign In";
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
		<div>
			<!-- Form which will go to the submit a spot page -->
			<form action="search.php" onsubmit="validateSignIn(this)" method="post">
				<div class="registerBox" id="sign-in">
					<!-- Get email and password from user -->
					<h1>Sign In</h1>
					<label for="email"><b>Email</b></label><br>
					<input type="email" placeholder="Enter Email" id="email" name="email" required> <br>
					<label for="password"><b>Password</b></label><br>
					<input type="password" placeholder="Enter Password" id="password" name="password" required><br>
					<input type="submit" class="register-button" value="Sign In">
				</div>
			</form>
		</div>
	</div>
	<?php
        include('footer.php');
    ?>
</body>
</html> 