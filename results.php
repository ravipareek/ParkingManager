<?php
session_start();
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
			<?php	
			echo('<div class="mapView" id="mapId">');
			echo('</div>');
			echo('<hr>');
			// <!-- Bottom view of the flex -->
			echo('<div class="tableView">');


				if (isset($_POST["search"])){
			       $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'pareek', 'hello');

			       $name = $_POST["name"];
			       // $name = "";
			       $location = $_POST["location"];
			       $distance = $_POST["distance"];
			       // $distance = 10000000000000000;
			       $minPrice = $_POST["minPrice"];
			       $maxPrice = $_POST["maxPrice"];
			       $minRating = $_POST["minRating"];
			       $type = $_POST["type"];

			       list($current_longitude, $current_latitude) = explode(',', $location);

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
				        $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'pareek', 'hello');
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						// print_r("Reached");
						$result = $pdo->query("SELECT parkingSpot.pid from parkingSpot inner join review on parkingSpot.pid = review.pid where parkingSpot.name like '%$name%' and parkingSpot.price between '$minPrice' and '$maxPrice' and parkingSpot.type = type and 111.111 * DEGREES(ACOS(LEAST(COS(RADIANS(parkingSpot.latitude)) * COS(RADIANS('$current_latitude')) * COS(RADIANS(parkingSpot.longitude - ('$current_longitude'))) + SIN(RADIANS(parkingSpot.latitude)) * SIN(RADIANS(parkingSpot.latitude)), 1.0))) < '$distance' group by parkingSpot.pid having avg(review.rating) > '$minRating' ");
						// 
						// print_r($result->fetchAll());
						foreach ($result as $spots) {
							$pid = $spots['pid'];
							$parkingSpotResults = $pdo->query("SELECT * from parkingSpot where pid = '$pid'");
							foreach ($parkingSpotResults as $ROW) {
								$ratingResult = $pdo->query("SELECT avg(rating) FROM review WHERE pid= '$pid'");
								$avgRating = round($ratingResult->fetchAll()[0][0],5);

								$distanceBetween = 111.111 * rad2deg(ACOS(min(COS(deg2rad($ROW['latitude'])) * COS(deg2rad('$current_latitude')) * COS(deg2rad($ROW['longitude'] - ('$current_longitude'))) + SIN(deg2rad($ROW['latitude'])) * SIN(deg2rad($ROW['latitude'])), 1.0)));

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
						echo $e->getMessage();
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
