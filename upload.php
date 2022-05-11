<?php
include_once 'header.php';
include_once 'index.php';

if (isset($_POST['submit'])) {
  require_once "dbh.inc.php";
  require_once 'functions.inc.php';
  
  echo "<script type='text/javascript'>alert('Your Order Has Been Submitted!');</script>";
  $file = $_FILES['file'];

  $fileName = $_FILES['file']['name'];
  $fileTmpName = $_FILES['file']['tmp_name'];
  $fileSize = $_FILES['file']['size'];
  $fileError = $_FILES['file']['error'];
  $fileType = $_FILES['file']['type'];
	
  $message = $_POST['message'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $userId = $_SESSION["userid"];
  $orderDate = $_POST['date']." ".$_POST['time'];
  
  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  
  $allowed = array('jpg', 'jpeg', 'png', 'pdf', 'gif');

  
  if (in_array($fileActualExt, $allowed)) {
    if ($fileError === 0) {
      if ($fileSize < 1000000) {       
        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
        $fileDestination = '/home/dh_2g7hww/specialoccasionmessagesender.xyz/Project/images/' . $fileNameNew;
        move_uploaded_file($fileTmpName, $fileDestination);
		  
		submitMessage($conn, $message, $fileNameNew, $name, $email, $userId, $orderDate);
		
			
        
       
      }
      else {
        echo "<p>Your file is too big!</p>";
      }
    }
    else {
      echo "There was an error uploading your file!";
    }
  }
  else {
    echo "You cannot upload files of this type!";
  }
    
}
