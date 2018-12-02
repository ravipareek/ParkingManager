<?php
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
?>


<script type="application/ld+json">
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
</script>

<!-- Body is a flex so header, and footer are at the top and bottom of pages -->
<body onload="makeMapIndividual()">
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
				<img src="res/parking_spot1.jpg" class="parkingPic" alt="Image of parking spot for result 1"> <hr>
				<video class="spotVideo" controls>
					<source src="res/sample.mp4" type="video/mp4">
				</video><hr>
				<div class="mapView" id="mapId">
					<!--<img src="res/lotM.jpg" class="parkingPic" alt="Map of location of Lot M">-->
				</div>
			</div>
			<div class="parkingDetailsContent">
				<h1 id="spotHeader">Parking spot at Lot M</h1>
				<!-- Using it this way even though this is not the correct way. Since we cannot use javascript, I am doing it this way -->
				<a href="submission.php"><button class="editButton" title="Edit"></button></a>
				<h2 id="price">$7.00</h2>
				<h4>★★★★ (3 Reviews)</h4>
				<!-- Using a table to display various details about the spot -->
				<table class="parkingDetailsTable">
					<tr>
						<td>Location</td>
						<td>(43.260879,-79.91922540000002) - McMaster University</td>
					</tr>
					<tr>
						<td>Distance</td>
						<td>4.53 KM</td>
					</tr>
					<tr>
						<td>Type of Parking</td>
						<td>Outdoor</td>
					</tr>
					<tr>
						<td>Description</td>
						<td><p>A wonderful spot that is walking distance to McMaster University. There is also a shuttle bus 2 minutes away which goes directly to the campus and stops at thode library.</p></td>
					</tr>
				</table>
				<hr>
				<!-- Displaying the reviews -->
				<div class="parkingReviewTable">
					<!-- Displaying the review made by a user along with their profile picture, name, rating and the review -->
						<div class="parkingReview">
							<div class="reviwer">
								<figure>
									<img src="res/profilePicture.jpg" alt="User's profile picture" class="profilePicture reviewer">
									<figcaption>Pareek Ravi</figcaption>
								</figure>
							</div>
							<h2>Great spot</h2>
							<p>★★★★</p>
							<p>This is an amazing spot that is very close to the campus. There is plenty of space available for a large SUV. Will be using it again and will be telling all my friends about it too</p>
						</div>
						<div class="parkingReview">
							<div class="reviwer">
								<figure>
									<img src="res/profilePicture.jpg" alt="User's profile picture" class="profilePicture reviewer">
									<figcaption>John Wylie</figcaption>
								</figure>
							</div>
							<h2>My car was covered in bird poop!!</h2>
							<p>★★★</p>
							<p>This spot is not bad, but there are far too many pigeons in the area and my car was completely covered in bird poop. I can't believe so many people are willing to park their cars in these areas.</p>
						</div>
						<div class="parkingReview">
							<div class="reviwer">
								<figure>
									<img src="res/profilePicture.jpg" alt="User's profile picture" class="profilePicture reviewer">
									<figcaption>Scott Wood</figcaption>
								</figure>
							</div>
							<h2>Good enough for a student</h2>
							<p>★★★★</p>
							<p>As a student who attends McMaster, this spot is good enough. There is a slight walk to the edge of campus, but the shuttle is pretty frequent and only takes 2 minutes. I basically use it everyday</p>
						</div>
				</div>
			</div>
		</div>
	</div>
    <?php
    include('footer.php');
     ?>
</body>
</html>