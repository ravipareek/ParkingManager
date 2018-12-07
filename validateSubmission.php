<?php
  session_start();
  use Aws\S3\Exception\S3Exception;

  // need aws s3 bucket info
  require('useAws.php');

  // if post was submit and image attached
  if (isset($_POST["submit"]) && isset($_FILES['image'])){

       // get image file
       $imageFile = $_FILES['image'];

       // get all post data
       $name = $_POST["name"];
       $description = $_POST["description"];
       $type = $_POST["type"];
       $longitude = $_POST["long"];
       $latitude = $_POST["lat"];
       $photo = $imageFile["name"];
       $price = $_POST["price"];
       $uid = $_SESSION['uid'];

       // open db connection

       $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'pareek', 'hello');
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       // query to check if user has already submitted same spot
       $query = "SELECT * from parkingSpot where parkingSpot.uid = '$uid' and parkingSpot.longitude='$longitude' and parkingSpot.latitude='$latitude'";
       // echo $query;
       $existingSpots = $pdo->query($query);

       // make user is logged in and user has not previously submitted same spot
       if ($existingSpots->rowCount() < 1 && !empty($uid)){
        try{

          // get temp file name and get the file extension
          $tmp_name = $imageFile['tmp_name'];
          $extension = explode('.',$imageFile['name']);
          $extension = strtolower(end($extension));

          // get a new unique file name with extension
          $key = md5(uniqid());
          $tmp_file_name = "{$key}.{$extension}";

          // make a new directory to store temp file
          if (!file_exists('/tmp/tmpfile')) {
            mkdir('/tmp/tmpfile');
          }
          // echo $tmp_file_name;

          // copy image data into new image file in new location
          $tmp_file_path = "/tmp/tmpfile/".$tmp_file_name;
          $fileContents = file_get_contents($tmp_name);
          $tempFile = fopen($tmp_file_path,"w");
          $tempFile = file_put_contents($tmp_file_path, $fileContents);

          // redeclare db connection (again just to be safe)
          $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'pareek', 'hello');
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // insert parking spot data into table
            $sql = 'INSERT INTO parkingSpot(name, description, latitude, longitude, type, uid, photo,price) VALUES(:name, :description, :lat, :long, :type, :uid, :photoURL,:price)';
              $stmt = $pdo->prepare($sql);
              $stmt->bindValue(':name', $name);
              $stmt->bindValue(':description', $description);
              $stmt->bindValue(':lat', $latitude);
              $stmt->bindValue(':long', $longitude);
              $stmt->bindValue(':type', $type);
              $stmt->bindValue(':uid', $uid);
              $stmt->bindValue(':photoURL', $tmp_file_name); 
              $stmt->bindValue(':price', $price);
            // echo $sql;
            $stmt->execute();

          // upload image to s3
          // aws access key and secret key are stored using aws best practices for credentials 
            $uploadResult = $s3->putObject([
                'Bucket' => 'parkingspots-pareek',
                'Key' => "images/".$tmp_file_name,
                'Body' => fopen($tmp_file_path, 'rb'),
                "ACL" => 'public-read'
            ]);

            // echo $uploadResult;


          } catch(S3Exception $e){
            // echo $e->getMessage();
          } catch(PDOException $e){
            // echo $e->getMessage();
          } catch(Exception $e){
            // echo $e->getMessage();
          }

          // get the parking spot id that was just posted
          $postedSpot = $pdo->query("SELECT * from parkingSpot where parkingSpot.uid = '$uid' and parkingSpot.longitude=longitude and parkingSpot.latitude=latitude");
          $pid = $postedSpot->fetchAll()[0][0];
          // echo $pid;
          
          // redirect to the new location
          header("location: parking.php?parking=".$pid);
        }
        // user not signed in
        elseif (empty($uid)){
          echo "<script>alert('Please sign in')</script>";
          sleep(1);
        }
        // parking spot already exists so redirect to spot
        else{
          $postedSpot = $pdo->query("SELECT * from parkingSpot where parkingSpot.uid = '$uid' and parkingSpot.longitude=longitude and parkingSpot.latitude=latitude");
          $pid = $postedSpot->fetchAll()[0][0];
          // echo "<script>alert('You have already made a spot there')</script>";
          sleep(1);
          header("location: parking.php?parking=".$pid);
        }
  }
  else{
    // die("Something went wrong");
  }
?>