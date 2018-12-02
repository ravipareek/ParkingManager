<?php
$PageTitle="Results";
function customPageHeader(){?>
<!--Map related css and js-->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
	  integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
	  crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"
		integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
		crossorigin=""></script>

<?php }
include('head.php');
?>
<!-- Body is a flex so header, and footer are at the top and bottom of pages -->
<body onload="makeMap()">
	<div>
		<!-- Header to have a logo and my app name -->
        <?php
            include('navBar.php');
        ?>
		<!-- A flex box to seperate items into left and right columns -->
		<div class="centered">
			<!-- Ability to update the search -->
			<!-- This is on the left of the flex box -->
			<div class="updateSearch">
				<form action="results.php" onsubmit="return validateSearch(this)">
					<!-- Get the location they want to search along with all other inputs -->
					<div class="registerBox updateBox">
						<div>
							<label for="searchBar"><b>Location</b></label> <br>
							<div class="sliderContainer">
								<input type="search" id="searchBar" name="location" placeholder="Location of parking spot">
								<input type="image" id="locationButton" src="res/location_icon_clear.png" width="15" height="15" title="Current Location" alt="Current Location" onclick="getLocation(); return false;">
							</div>
							<br>
							<hr>
							<label for="distance"><b>Distance from Current Location</b></label><br>
							<div class="sliderContainer">
								<p class="textRange">0 km </p>
			  					<input type="range" name="distance" id="dist" value="5" min="0" max="10" step="0.01" class="slider" onchange="modifyOffset(this)">
			  					<p class="textRange"> 10 km</p>
			  					<output for="dist" id="distance">5</output><br>
		  					</div>
		  					<hr>
		  					<!-- Displaying the prices so the labels match with the inputs -->
							<div class="priceTable">
								<div class="col">
									<label for="minPrice" id="minPriceLabel"><b>Min Price ($)</b></label><br>
									<input type="number" name="min" id="minPrice" step="0.01" min="0">
								</div>
								<div class="col">
									<label for="maxPrice" id="maxPriceLabel"><b>Max Price ($)</b></label><br>
									<input type="number" name="max" id="maxPrice" step="0.01" min="0">
								</div>
							</div>
							<hr>
							<div class="selectDropdown">
								<label for="rating"><b>Min Rating</b></label>
								<select id="rating">
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
								<select id="type">
									<option value="Any">Any</option>
									<option value="Outdoor">Outdoor</option>
									<option value="Underground">Underground</option>
									<option value="Private">Private</option>
								</select>
							</div>
						</div>
						<input type="submit" class="register-button" value="Search">
					</div>
				</form>
			</div>
			<!-- This is the right side of the flex -->
			<!-- This is also a vertical flexbox -->
			<div class="results">
				<!-- Top view of the flex -->
				<div class="mapView" id="mapId">
					<!--<img src="res/map_view.png" id="map" alt="Map of parking results">-->
				</div>
				<hr>
				<!-- Bottom view of the flex -->
				<div class="tableView">
					<!-- The div is inside here because javascript is not allowed, this is only for now -->
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
					<div class="parkingSpot">
						<img src="res/parking_spot2.jpg" style="margin: 10px 10px" width="150" height="150" alt="Image of parking spot for result 2">
						<div class="parkingInfo">
							<h3>1150 Hamilton RR 8</h3>
							<h4>Distance: 0.8 KM</h4>
							<h4>Location: (43.257985, -79.913611)</h4>
							<hr>
							<p class="desciption">Parking spot available in driveway of 1150 Hamilton Regional Road 8</p>
						</div>
						<div class="parkingCostRating">
							<h3>$20</h3>
							<h4>★★★★★</h4>
						</div>
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
