<?php 
	session_start();
	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);
	$pid;
	if (isset($_POST["review"])){
		try{
	        $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'pareek', 'hello');
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// get form data
			$title = $_POST['title'];
			$review = $_POST['description'];
			$rating = $_POST['rating'];

			// get data from url and session
			$pid = $_GET['parking'];
			$uid = $_SESSION['uid'];

			// open sql connection
			$pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'pareek', 'hello');
       		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       		// query to getexisting review by user to this post
       		$query = "SELECT * from review where pid = {$pid} and uid ={$uid}";
       		$existingReview = $pdo->query($query);
       		// user can only submit 1 review per parking spot
	       if ($existingReview->rowCount() < 1 && !empty($uid)){
	       	// 	insert review
	       		$sql = 'INSERT INTO review(pid, uid, rating, description, title) VALUES(:parkingID, :userID, :rating, :review, :title)';
	            $stmt = $pdo->prepare($sql);
	            $stmt->bindValue(':parkingID', $pid);
	            $stmt->bindValue(':userID', $uid);
	            $stmt->bindValue(':review', $review);
	            $stmt->bindValue(':rating', $rating);
	            $stmt->bindValue(':title', $title);
	            // echo $sql;
	            $stmt->execute();
	            // redirect back to parking spot
	            header("location: parking.php?parking=".$pid);
	       }
	       elseif(empty($uid)){
	       	echo "<script>alert('Please sign in')</script>";
	       	sleep(1);
	       	// header("location: parking.php?parking=".$pid);
	       }
	       else{
	       	echo "<script>alert('You have already subitted a review')</script>";
	       	sleep(1);
	       	history.go(-1);
	       }
		} catch(PDOExeption $e){
			echo $e->getMessage();
		}
	}	
?>