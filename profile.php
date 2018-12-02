<?php
$PageTitle="Profile Page";
include('head.php');
?>
<!-- Body is a flex so header, and footer are at the top and bottom of pages -->
<body>
		<!-- Header to have a logo and my app name -->
	<div class="table">
        <?php
            include('navBar.php');
        ?>
		<!-- wrap the page nicely -->
		<div class="profilePage">
			<!-- flex box left anfd right side -->
			<div class="profileContainer">
				<!-- the image section of the page -->
				<div class="floatProfileSection">
					<img src="res/profilePicture.jpg" alt="User's profile picture" class="profilePicture">
					<h1 style="text-align: center;">Pareek Ravi</h1>
					<h2 style="text-align: center;">ravip2@mcmaster.ca</h2>
				</div>
				<!-- display on right flex -->
				<div class="listings">
					<div class="openListings">
						<h2>Available Listings</h2>
						<a href="parking.php">
								<div class="parkingSpot">
									<img src="res/parking_spot1.jpg" style="margin: 10px 10px;" width="150" height="150" alt="Image of parking spot for result 1">
									<div class="parkingInfo">
										<h3>Parking spot at Lot M</h3>
										<h4>Distance: 4.53 KM</h4>
										<h4>Location: (43.260879,-79.91922540000002)</h4>
										<hr>
										<p class="desciption">A wonderful spot that is walking distance to McMaster University. There is also a shuttle bus 2 minutes away which goes directly to the campus and stops at thode library.</p>
									</div>
									<div class="parkingCostRating">
										<h3>$7</h3>
										<h4>★★★★</h4>
									</div>
								</div>
							</a>
					</div>

					<div class="closedListings">
						<h2>Occupied Listings</h2>
						<a href="parking.php">
								<div class="parkingSpot">
									<img src="res/parking_spot1.jpg" style="margin: 10px 10px;" width="150" height="150" alt="Image of parking spot for result 1">
									<div class="parkingInfo">
										<h3>Parking spot at Lot M</h3>
										<h4>Distance: 4.53 KM</h4>
										<h4>Location: (43.260879,-79.91922540000002)</h4>
										<hr>
										<p class="desciption">A wonderful spot that is walking distance to McMaster University. There is also a shuttle bus 2 minutes away which goes directly to the campus and stops at thode library.</p>
									</div>
									<div class="parkingCostRating">
										<h3>$7</h3>
										<h4>★★★★</h4>
									</div>
								</div>
							</a>
					</div>
				</div>
			</div>
		</div>
		<?php
            include('footer.php');
        ?>
	</div>
</body>
</html>
