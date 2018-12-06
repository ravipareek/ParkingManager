<?php
  session_start();
  use Aws\S3\Exception\S3Exception;
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  ini_set('log_errors', 1);

  require('useAws.php');

  if (isset($_POST["submit"]) && isset($_FILES['image'])){

       $imageFile = $_FILES['image'];
       $name = $_POST["name"];
       $description = $_POST["description"];
       $type = $_POST["type"];
       $longitude = $_POST["long"];
       $latitude = $_POST["lat"];
       $photo = $imageFile["name"];
       $price = $_POST["price"];
       $uid = $_SESSION['uid'];

       $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'pareek', 'hello');
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       $query = "SELECT * from parkingSpot where parkingSpot.uid = '$uid' and parkingSpot.longitude='$longitude' and parkingSpot.latitude='$latitude'";
       // echo $query;
       $existingSpots = $pdo->query($query);

       // print_r($existingSpots->rowCount()."| ");

       if ($existingSpots->rowCount() < 1 && !empty($uid)){
        try{

          // copy image locally to upload
          $tmp_name = $imageFile['tmp_name'];
          $extension = explode('.',$imageFile['name']);
          $extension = strtolower(end($extension));

          $key = md5(uniqid());
          $tmp_file_name = "{$key}.{$extension}";

          if (!file_exists('/tmp/tmpfile')) {
            mkdir('/tmp/tmpfile');
          }
          // echo $tmp_file_name;

          $tmp_file_path = "/tmp/tmpfile/".$tmp_file_name;
          $fileContents = file_get_contents($tmp_name);
          $tempFile = fopen($tmp_file_path,"w");
          $tempFile = file_put_contents($tmp_file_path, $fileContents);

          $pdo = new PDO('mysql:host=localhost;dbname=comp4ww3', 'pareek', 'hello');
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
            $uploadResult = $s3->putObject([
                'Bucket' => 'parkingspots-pareek',
                'Key' => "images/".$tmp_file_name,
                'Body' => fopen($tmp_file_path, 'rb'),
                "ACL" => 'public-read'
            ]);

            // echo $uploadResult;


          } catch(S3Exception $e){
            echo $e->getMessage();
          } catch(PDOException $e){
            echo $e->getMessage();
          } catch(Exception $e){
            echo $e->getMessage();
          }

          $postedSpot = $pdo->query("SELECT * from parkingSpot where parkingSpot.uid = '$uid' and parkingSpot.longitude=longitude and parkingSpot.latitude=latitude");
          $pid = $postedSpot->fetchAll()[0][0];
          echo $pid;
          
          header("location: parking.php?parking=".$pid);
        }
        elseif (empty($uid)){
          echo "<script>alert('Please sign in')</script>";
        }
        else{
          $postedSpot = $pdo->query("SELECT * from parkingSpot where parkingSpot.uid = '$uid' and parkingSpot.longitude=longitude and parkingSpot.latitude=latitude");
          $pid = $postedSpot->fetchAll()[0][0];
          print_r($pid);
          header("location: parking.php?parking=".$pid);
        }
  }
  else{
    // die("Something went wrong");
  }
?>