<!-- the nav bar which is repeated everywhere -->


<header>
		<div class="logo">
			<picture>
				<source srcset="res/parking_icon_192.png" media="(max-width: 800px)">
				<img src="res/parking_icon.png" width="50" height="50" alt="Logo for Parking Manager">
			</picture>
		</div>
		<div class="appName">
			<h1>Parking Manager</h1>
		</div>
	</header>
	<!-- The navigation menu -->
	<nav>
		<!-- This is in a flex box directioned by row -->
		<div class="topnav">
			<!-- Left nav to the left -->
			<div class="leftNav">
		  		<a href="submission.php" title="Post a Spot">Post a Spot</a>
		  		<a href="profile.php" title="Profile">Profile</a>
		  		<a class="active" href="search.php" title="Search">Search</a>
	  		</div>
	  		<!-- Right nav to the right -->
  		<div class="rightNav">
  			<a id="logout" href="sign-in.php?logout=true">Logout</a>
  		</div>
  		</div>
	</nav>