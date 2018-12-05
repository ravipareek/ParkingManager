<?php
$PageTitle="Submit a Spot";
include('head.php');
?>

<body>
    <?php
        include('navBar.php');
    ?>
	<!-- center box -->
	<div class="centered">
		<form action="parking.php" method="post" onsubmit="return validateSubmit(this)">
			<div id="submissionBox" class="registerBox">
				<!-- Flex of form data -->
				<div id="topFlex">
					<!-- flex of data entry -->
					<div class="formLeft">
						<label for="name"><b>Spot Name</b></label><br>
						<input type="text" placeholder="Enter a name for the spot" id="name" name="name" required> <br>
						<label for="description"><b>Description</b></label><br>
						<textarea id="description" placeholder="Enter a description" cols="30" rows="5" name="description" required></textarea> <br>
						<label for="type"><b>Type of Spot</b></label>
						<select id="type" required name="type">
							<option value="none">None</option>
							<option value="Outdoor">Outdoor</option>
							<option value="Underground">Underground</option>
							<option value="Private">Private</option>
						</select> <br>
						<label for="lat"><b>Latitude</b></label><br>
						<input type="number" placeholder="Enter the latitude" id="lat" name="lat" required step="0.00001"> <br>
						<label for="lon"><b>Longitude</b></label><br>
						<input type="number" placeholder="Enter the longitude" id="lon" name="long" required step="0.00001"> <br>
					</div>
					<!-- flex of file inputs -->
					<div class="imageRight">
						<label for="image"><b>Upload an image</b></label>
						<input type="file" id="image" name="image" accept="image/*" required> <br> <br>
						<label for="video"><b>Upload a video</b> (Optional)</label>
						<input type="file" id="video" name="video" accept="video/*">
					</div>
				</div>
				<!-- flex to have submit button centered -->
				<div id="bottomFlex">
					<input type="submit" class="register-button" name="submit" value="Submit">
				</div>
			</div>
		</form>
	</div>	
	<?php
        include('footer.php');
     ?>
</body>
</html>
