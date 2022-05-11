<?php
  $msg = "";
  
  // If upload button is clicked ...
  if (isset($_POST['upload'])) {
  
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];    
        $folder = "Project/images/".$filename;
          
    	require_once "dbh.inc.php";
  
        // Get all the submitted data from the form
        $sql = "INSERT INTO image (filename) VALUES ('$filename')";
  
        // Execute query
//        $conn->query($sql);
          
        // Now let's move the uploaded image into the folder: image
        if (move_uploaded_file($tempname, $folder))  {
            echo ("Image uploaded successfully") ;
        }else{
            echo ("Failed to upload image") ;
      }
  }
//  $result = mysqli_query($db, "SELECT * FROM image");
?>