
<?php

require_once "dbh.inc.php";

if ($conn->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

date_default_timezone_set("America/New_York");
$d=strtotime("now");
$date = date("Y-m-d H:i:00", $d);

$result = $conn->query("SELECT * FROM orders o LEFT JOIN messages m ON m.messageId = o.messageId LEFT JOIN users u ON u.userId = o.userId WHERE orderDateSend = '".$date."'");
// $stmt->bind_param('s', $date);
// $result = $stmt->execute();
printf("Select returned %d rows.\n", $result->num_rows);
while ($row = mysqli_fetch_assoc($result))
 {
    $from = "admin@specialoccasionmessagesender.xyz";
    $to = $row['messageRecipientEmail'];
    $subject = "Special Occasion";
    $fileName = 'https://www.specialoccasionmessagesender.xyz/Project/images/' . $row['messageFileName'];
    $message = '<html><body>';
    $message .= '<h1 style="color: #800060;">' .$row['messageText'].'</h1>';
    $message .= '<img src="'.$fileName.'" alt="picture"><br>';
    $message .= '<a href="'.$fileName.'">Cant see the image? Click Here.</a><br>';
    $message .= '<p>From: ' .$row['usersName'].'</p>';
    $message .= '</body></html>';
    
    
    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // More headers
    $headers .= "From:" . $from . "\r\n";
    mail($to,$subject,$message, $headers);
 }



$conn -> close();


?>




