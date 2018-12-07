<?php
session_start();
	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);
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
<body>
	<div>
		<!-- Header to have a logo and my app name -->
        <?php
            include('navBar.php');
        ?>
    </div>
		<!-- A flex box to seperate items into left and right columns -->
		<div class="centered">
			<!-- Ability to update the search -->
			<!-- This is on the left of the flex box -->
			<div class="updateSearch">
				<form action="results.php" method="post" onsubmit="return validateSearch(this)">
					<!-- Get the location they want to search along with all other inputs -->
					<div class="registerBox updateBox">
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
							<!-- doesnt actually search by this -->
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
			<!-- This is the right side of the flex -->
			<!-- This is also a vertical flexbox -->
			<div class="results">
				<!-- Top view of the flex -->
			<?php	
			echo('<div class="mapView" id="mapId">');
			echo('</div>');
			echo('<hr>');
			// <!-- Bottom view of the flex -->
			echo('<div class="tableView">');


				if (isset($_POST["search"])){
					// open db
			       $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'pareek', 'hello');

					// get posted data
			       $name = $_POST["name"];
			       // $name = "";
			       $location = $_POST["location"];
			       $distance = $_POST["distance"];
			       // $distance = 10000000000000000;
			       $minPrice = $_POST["minPrice"];
			       $maxPrice = $_POST["maxPrice"];
			       $minRating = $_POST["minRating"];
			       $type = $_POST["type"];

			       // split to get longitude and latitude split by comma
			       list($current_longitude, $current_latitude) = explode(',', $location);

			       // js script for map creation
			       echo "<script>

						console.log('Map');

					    //hard coding longitude and latitude
					    longitude = ",$current_longitude,";
					    latitude = ",$current_latitude,";

					    console.log(longitude + ' ' + latitude);

					    //Make map square
					    var mapElement = document.getElementById('mapId');
					    var mapBounds = mapElement.offsetWidth;
					    mapElement.style.height =  (mapBounds * 0.7) + 'px';

					    let token = 'sk.eyJ1IjoicGFyZWVraXRlZWtpIiwiYSI6ImNqb2RkazZ4NzEyeXEzcHJ3OXloNnhjdGkifQ.fbyzmtswUJRTNKzrVYwu2g';
					    let myMap = L.map('mapId').setView([latitude,longitude], 15);

					    //create map
					    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
					        attribution: 'Map data &copy; <a href=\'https://www.openstreetmap.org/\'>OpenStreetMap</a> contributors, <a href=\'https://creativecommons.org/licenses/by-sa/2.0/\'>CC-BY-SA</a>, Imagery © <a href=\'https://www.mapbox.com/\'>Mapbox</a>',
					        maxZoom: 20,
					        id: 'mapbox.streets',
					        accessToken: token
					    }).addTo(myMap);

				    </script>";

			       try{
			       	// redeclare db
				        $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'pareek', 'hello');
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
						// search based on name, price range and distance
						// does not search by type because of 'any' field

						// distance calculation
						$query = "SELECT parkingSpot.pid from parkingSpot inner join review on parkingSpot.pid = review.pid where parkingSpot.name like '%$name%' and parkingSpot.price between '$minPrice' and '$maxPrice' and 111.111 * DEGREES(ACOS(LEAST(COS(RADIANS(parkingSpot.latitude)) * COS(RADIANS('$current_latitude')) * COS(RADIANS(parkingSpot.longitude - ('$current_longitude'))) + SIN(RADIANS(parkingSpot.latitude)) * SIN(RADIANS(parkingSpot.latitude)), 1.0))) < '$distance' group by parkingSpot.pid having avg(review.rating) >= '$minRating' ";
						$result = $pdo->query($query);

						// no results found
						if ($result->rowCount() == 0){
							echo "<script>alert('No results found')</script>";
							sleep(1);
							// header("location: search.php");
						}
						// iterate through all results
						foreach ($result as $spots) {
							// store parking id
							$pid = $spots['pid'];
							// get that spot's details
							$parkingSpotResults = $pdo->query("SELECT * from parkingSpot where pid = '$pid'");
							// iterate through the details of the spot
							foreach ($parkingSpotResults as $ROW) {
								// get the average rating of the spot
								$ratingResult = $pdo->query("SELECT avg(rating) FROM review WHERE pid= '$pid'");
								// round to 5 decimal places
								$avgRating = round($ratingResult->fetchAll()[0][0],5);

								// distance calc
								$distanceBetween = 111.111 * rad2deg(ACOS(min(COS(deg2rad($ROW['latitude'])) * COS(deg2rad('$current_latitude')) * COS(deg2rad($ROW['longitude'] - ('$current_longitude'))) + SIN(deg2rad($ROW['latitude'])) * SIN(deg2rad($ROW['latitude'])), 1.0)));

								// js script to create markers on map
								// populate table with spot data
							    echo "<script>

								    // create marker
								    var marker = L.marker([",$ROW['longitude'],",",$ROW['latitude'],"]).addTo(myMap);
								    marker.bindPopup('",$ROW['name']," <br> Price: $",$ROW['price']," <br> <a href=\'parking.php?parking=",$ROW['pid'],"&distanceBetween=",$distanceBetween,"\'>Details</a>');
								</script>";
						
								echo '<a href="parking.php?parking=',$ROW['pid'],'&distanceBetween=',$distanceBetween,'">';
								echo '<div class="parkingSpot">
							<img src="res/parking_spot1.jpg" style="margin: 10px 10px;" width="150" height="150" alt="Image of parking spot for result 1">
							<div class="parkingInfo">';
								echo '<h3>',$ROW['name'],'</h3>';
								echo '<h4> Distance: ',$distanceBetween,' km</h4>';
								echo '<h4> Location: ',$ROW['longitude'],',',$ROW['latitude'],'</h4> <hr>';
								echo '<p class="desciption">',$ROW['desciption'],'</p> </div>';
								echo '<div class="parkingCostRating">';
								echo '<h3>$',$ROW['price'],'</h3>';
								echo '<h4> Rating: ',$avgRating,'/5</h4>';
								echo '</div></div></a>';
							}
						}
						echo ('</div>');
					} catch (PDOException $e){
						// echo $e->getMessage();
					}

				}
			?>
			</div>
		</div>
		<?php
            include('footer.php');
        ?>
</body>
</html>
