<?php

include_once "header.php"
require_once "dbh.inc.php";

if ($conn->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}



$result = $conn->query("SELECT * FROM orders o LEFT JOIN messages m ON m.messageId = o.messageId LEFT JOIN users u ON u.userId = o.userId WHERE orderDateSend = '".$date."'");

printf("Select returned %d rows.\n", $result->num_rows);



// while ($row = mysqli_fetch_assoc($result))
//  {
//     $from = "admin@specialoccasionmessagesender.xyz";
//     $to = $row['messageRecipientEmail'];
//     $subject = "Special Occasion";
//     $fileName = 'https://www.specialoccasionmessagesender.xyz/Project/images/' . $row['messageFileName'];
//     $message = '<html><body>';
//     $message .= '<h1 style="color:#f40;">' .$row['messageText'].'</h1>';
//     $message .= '<img src="'.$fileName.'" alt="picture">';
//     $message .= '</body></html>';
    
    
//     // Always set content-type when sending HTML email
//     $headers = "MIME-Version: 1.0" . "\r\n";
//     $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

//     // More headers
//     $headers .= "From:" . $from . "\r\n";
//     mail($to,$subject,$message, $headers);
//  }



$conn -> close();


?>