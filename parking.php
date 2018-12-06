<?php
session_start();

use Aws\S3\Exception\S3Exception;
require('useAws.php');

$PageTitle="Parking Spot Details";
function customPageHeader(){?>
    <!-- Responsive design -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- Meta data for facebook and twitter -->
    <meta property="og:title" content="Parking Spot" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://4ww3.pareekravi.com/parking.php"/>
    <meta property="og:description" content="Details on a parking spot at Lot M">
    <meta property="og:site_name" content="Parking Manager">
    <meta property="og:locale" content="en_US" />
    <meta property="og:image" content="http://johnnyonthespotservices.com/wp-content/uploads/2014/04/DSC04199.jpg"/>
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="400"/>
    <meta property="og:image:height" content="400"/>
    <meta property="og:image:alt" content="A map of the parking spot's location" />
    <meta property="og:image:alt" content="The parking spot" />
    <meta property="fb:app_id" content="" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:creator" content="@pareekiteeki" />
    <meta property="og:title" content="Parking Spot at Lot M" />


<!--Map related css and js-->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
	  integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
	  crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"
		integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
		crossorigin=""></script>

<?php }

include('head.php');

$name;
$description;
$type;
$longitude;
$latitude;
$photo;
$price;
$avgRating;
$pid;
$reviewCount;
$distanceBetween;

	// ini_set('display_errors',1);
	

	{

		$parkID = $_GET['parking'];
		$distanceBetween = $_GET['distanceBetween'];
		$pid = $parkID;

		try {

			$pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'pareek', 'hello');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$result = $pdo->query("SELECT * FROM parkingSpot where pid = $parkID");

			if($result->rowCount() == 0){
				// page does not exist
				// print_r("DOES NOT EXIST");
				header('HTTP/1.1 404 Not Found');
				header('Location: 404.php');
				$_GET['e'] = 404;
				exit;
			}


			$reviewResult = $pdo->query("SELECT count(rid) FROM review where pid = $parkID");
			$reviewCount = $reviewResult->fetchAll()[0][0];
			

			foreach ($result as $ROW) {
				$newPID = $ROW['pid'];

				$ratingResult = $pdo->query("SELECT avg(rating) FROM review WHERE pid= $newPID");
				$avgRating = round($ratingResult->fetchAll()[0][0],2);

				$name = $ROW["name"];
				$type = $ROW["type"];
				$description = $ROW["description"];
				$type = $ROW["type"];
				$longitude = $ROW["longitude"];
				$latitude = $ROW["latitude"];
				$photo = $ROW["photo"];
				$price = $ROW['price'];

			}

			$downloadedImage = $s3->getObject(array(
				'Bucket' => 'parkingspots-pareek',
				'Key' => "images/".$imageName
			));

			$imageURL =  $downloadedImage['@metadata']['effectiveUri'].$photo;
			// echo $imageURL;

		}
		catch (PDOException $e) {
			// echo $e->getMessage();
			header('HTTP/1.1 404 Not Found');
				header('Location: 404.php');
				$_GET['e'] = 404;
				exit;
		}


	}
?>


<!-- <script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Place",
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "43.261881",
    "longitude": "-79.930794"
  },
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "Hamilton",
    "addressRegion": "ON",
    "postalCode": "L8N 1E9",
    "streetAddress": "McMaster University Downtown Center"
  },
  "name": "McMaster Lot M",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4",
    "reviewCount": "3"
  },
  "review": [
    {
      "@type": "Review",
      "author": "Pareek Ravi",
      "description": "This is an amazing spot that is very close to the campus. There is plenty of space available for a large SUV. Will be using it again and will be telling all my friends about it too",
      "name": "Great Spot",
      "reviewRating": {
        "@type": "Rating",
        "bestRating": "5",
        "ratingValue": "4",
        "worstRating": "1"
      }
    },
    {
      "@type": "Review",
      "author": "John Wylie",
      "description": "This spot is not bad, but there are far too many pigeons in the area and my car was completely covered in bird poop. I can't believe so many people are willing to park their cars in these areas.",
      "name": "My car was covered in bird poop!!",
      "reviewRating": {
        "@type": "Rating",
        "bestRating": "5",
        "ratingValue": "3",
        "worstRating": "1"
      }
    },
     {
      "@type": "Review",
      "author": "Scott Wood",
      "description": "As a student who attends McMaster, this spot is good enough. There is a slight walk to the edge of campus, but the shuttle is pretty frequent and only takes 2 minutes.",
      "name": "Good Enough for a student",
      "reviewRating": {
        "@type": "Rating",
        "bestRating": "5",
        "ratingValue": "4",
        "worstRating": "1"
      }
    }
  ]

}
</script> -->

<!-- Body is a flex so header, and footer are at the top and bottom of pages -->
<body>
	<!-- Header to have a logo and my app name -->
	<?php
        include('navBar.php');
    ?>
	<!-- A wrapper to hold all the information for the parking spot and to help center the div-->
	<div class="parkingWrapper">
		<!-- This is in a flex such that the image is on the left and the details is on the right -->
		<div class="parkingDetails">
			<!-- Image of the parking spot and the map location below it -->
			<div class="parkingImage">
				<img src= <?php echo($imageURL)?> class="parkingPic" alt="Image of parking spot for result 1"> <hr>
				<video class="spotVideo" controls>
					<source src="res/sample.mp4" type="video/mp4">
				</video><hr>
				<div class="mapView" id="mapId">
					<!--<img src="res/lotM.jpg" class="parkingPic" alt="Map of location of Lot M">-->
					<?php 

						echo "<script>

							console.log('Map');

						    //hard coding longitude and latitude
						    longitude = ",$longitude,";
						    latitude = ",$latitude,";

						    console.log(longitude + ' ' + latitude);

						    //Make map square
						    var mapElement = document.getElementById('mapId');
						    var mapBounds = mapElement.offsetWidth;
						    mapElement.style.height =  (mapBounds * 0.9) + 'px';

						    let token = 'sk.eyJ1IjoicGFyZWVraXRlZWtpIiwiYSI6ImNqb2RkazZ4NzEyeXEzcHJ3OXloNnhjdGkifQ.fbyzmtswUJRTNKzrVYwu2g';
						    let myMap = L.map('mapId').setView([latitude,longitude], 16);

						    //create map
						    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
						        attribution: 'Map data &copy; <a href=\'https://www.openstreetmap.org/\'>OpenStreetMap</a> contributors, <a href=\'https://creativecommons.org/licenses/by-sa/2.0/\'>CC-BY-SA</a>, Imagery © <a href=\'https://www.mapbox.com/\'>Mapbox</a>',
						        maxZoom: 20,
						        id: 'mapbox.streets',
						        accessToken: token
						    }).addTo(myMap);

						    // create marker
						    var marker = L.marker([latitude,longitude]).addTo(myMap);
						    marker.bindPopup('",$name," <br> Price: $",$price," <br> <a href=\'parking.php?parking=",$pid,"&distanceBetween=",$distanceBetween,"\'>Details</a>');
						</script>";

					 ?>
				</div>
			</div>
			<div class="parkingDetailsContent">
				<h1 id="spotHeader"><?php echo($name)?></h1>
				<!-- Using it this way even though this is not the correct way. Since we cannot use javascript, I am doing it this way -->
				<a href="submission.php"><button class="editButton" title="Edit"></button></a>
				<!-- get php price variable -->
				<h2 id="price">$<?php echo($price)?></h2>
				<!-- get php rating information -->
				<h4><?php echo 'Rating: ',$avgRating,'/5 (',$reviewCount,' Reviews)'?></h4>

				<!-- Using a table to display various details about the spot -->
				<table class="parkingDetailsTable">
					<tr>
						<td>Location</td>
						<!-- get php location variables -->
						<td><?php echo '(',$longitude,',',$latitude,')'?></td>
					</tr>
					<tr>
						<td>Distance</td>
						<!-- get php distance variable -->
						<td><?php echo(round($distanceBetween,2))?> KM</td>
					</tr>
					<tr>
						<td>Type of Parking</td>
						<!-- get php parking type variable -->
						<td><?php echo($type)?></td>
					</tr>
					<tr>
						<td>Description</td>
						<!-- get php desciption variable -->
						<td><p><?php echo($description)?></p></td>
					</tr>
				</table>
				<hr>
				<!-- Displaying the reviews -->
				<div class="parkingReviewTable">
					<!-- Populate number of reviews by query result -->
					<?php
						try {
							// connect to db
							$pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'pareek', 'hello');
							$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							// get all reviews for this parking spot
							$result = $pdo->query("SELECT * FROM review where pid = $pid");

							// for each review
							foreach ($result as $ROW) {
								// print_r($ROW);
								$newPID = $ROW['pid'];
								$userID = $ROW['uid'];

								// get user who submitted review by query
								$user = $pdo->query("SELECT * FROM user where uid = $userID");
								// get user's name
								$userName = $user->fetchAll()[0]['name'];
								// print_r($ROW);
								
								// create divs and set image of user
								echo "<div class='parkingReview'>
							<div class='reviwer'>
								<br>
								<figure>
									<img src='res/profilePicture.jpg' alt='User\'s profile picture' class='profilePicture reviewer'>";
								// write user's name
								echo '<figcaption>', $userName,'</figcaption>';
								// close div
								echo '</figure></div>';
								// write review information in html format
								echo '<h2>',$ROW['title'],'</h2>';
								echo '<p>Rating: ',$ROW['rating'],'/5</p>';
								echo '<p>',$ROW['description'],'</p> <br></div>';
								// completed writing review
							}

						}
						catch (PDOException $e) {
							echo $e->getMessage();
						}
					?>

				</div>
			</div>
		</div>
	</div>
</body>
<?php
    include('footer.php');
     ?>
</html>