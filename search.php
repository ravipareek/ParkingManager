<?php
session_start();
	$PageTitle="Search...";
	include('head.php');
?>
<!-- Body is a flex so header, and footer are at the top and bottom of pages -->
<body>
	<!-- Header to have a logo and my app name -->
	<?php
        include('navBar.php');
    ?>
	<!-- Keep the search box centered on the page -->
	<div class="centered">
		<form action="results.php" method="post" onsubmit="return validateSearch(this)">
			<!-- Get the location they want to search along with all other inputs -->
			<div class="registerBox" id="searchBox">
				<div>
					<label for="searchBar"><b>Name</b></label> <br>
					<div class="">
						<input type="text" id="searchNameBar" name="name" placeholder="Name of parking spot">
					</div>
					<label for="searchBar"><b>Location</b></label> <br>
					<div class="sliderContainer">
						<input type="search" id="searchBar" name="location" placeholder="Location of parking spot - (longitude,latitude)">
						<input type="image" id="locationButton" src="res/location_icon_clear.png" width="15" height="15" title="Current Location" alt="Current Location" onclick="getLocation();return false;">
					</div>
					<br>
					<hr>
					<label><b>Distance from Current Location</b></label><br>
					<div class="sliderContainer">
						<p class="textRange">0 km </p>
	  					<input type="range" name="distance" id="dist" value="5" min="0" max="10" step="0.01" class="slider" onchange="modifyOffset(this)">
	  					<p class="textRange"> 10 km</p>
						<output for="dist"  id="distance">5</output>
  					</div>
  					<hr>
  					<!-- Displaying the prices so the labels match with the inputs -->
					<div class="priceTable">
						<div class="col">
							<label for="minPrice" id="minPriceLabel"><b>Min Price ($)</b></label><br>
							<input type="number" name="minPrice" id="minPrice" step="0.01" min="0">
						</div>
						<div class="col">
							<label for="maxPrice" id="maxPriceLabel"><b>Max Price ($)</b></label><br>
							<input type="number" name="maxPrice" id="maxPrice" step="0.01" min="0">
						</div>
					</div>
					<hr>
					<div class="selectDropdown">
						<label for="rating"><b>Min Rating</b></label>
						<select id="rating" name="minRating">
							<option value="0">Any</option>
							<option value="1">1 star</option>
							<option value="2">2 star</option>
							<option value="3">3 star</option>
							<option value="4">4 star</option>
							<option value="5">5 star</option>
						</select>
					</div>
					<div class="selectDropdown">
						<label for="type"><b>Type of Spot</b></label>
						<select id="type" name="type">
							<option value="Any">Any</option>
							<option value="Outdoor">Outdoor</option>
							<option value="Underground">Underground</option>
							<option value="Private">Private</option>
						</select>
					</div>
				</div>
				<input type="submit" class="register-button" name="search" value="Search">
			</div>
		</form>
	</div>
	<?php
        include('footer.php');
    ?>
</body>
</html>
