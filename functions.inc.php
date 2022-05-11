<?php

function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) {
	$result;
	if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeat)) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function invalidUid($username) {
	$result;
	if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function invalidEmail($email) {
	$result;
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function pwdMatch($pwd, $pwdrepeat) {
	$result;
	if ($pwd !== $pwdrepeat) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function uidExists($conn, $username) {
  $sql = "SELECT userId, usersUid, usersPwd FROM users WHERE usersUid = ? OR usersEmail = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
	 	header("location: signup.php?error=stmtfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt, "ss", $username, $username);
	mysqli_stmt_execute($stmt);

	
	$resultData = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	}
	else {
		$result = false;
		return $result;
	}

	mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $email, $username, $pwd) {
  $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";

	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
	 	header("location: signup.php?error=stmtfailed");
		exit();
	}

	$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

	mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	header("location: signup.php?error=none");
	exit();
}

function emptyInputLogin($username, $pwd) {
	$result;
	if (empty($username) || empty($pwd)) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function loginUser($conn, $username, $pwd) {
	$uidExists = uidExists($conn, $username);
	$GLOBALS = $uidExists;

	if ($uidExists === false) {
		header("location: login.php?error=wronglogin");
		exit();
	}

	$pwdHashed = $uidExists["usersPwd"];
	$checkPwd = password_verify($pwd, $pwdHashed);

	if ($checkPwd === false) {
		header("location: login.php?error=wronglogin");
		exit();
	}
	elseif ($checkPwd === true) {
		session_start();
		$_SESSION["userid"] = $uidExists["userId"];
		$_SESSION["useruid"] = $uidExists["usersUid"];
		header("location: index.php?error=none");
		exit();
	}
}


function submitMessage($conn, $message, $fileName, $name, $email, $userId, $orderDate){
	$sql = "INSERT INTO messages (messageText, messageFileName, messageRecipientName, messageRecipientEmail) VALUES (?, ?, ?, ?);";
	
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
	 	header("location: index.php?error=stmtfailed");
		exit();
	}
	
	mysqli_stmt_bind_param($stmt, "ssss", $message, $fileName, $name, $email);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);

	submitOrder($conn, $userId, mysqli_insert_id($conn), $orderDate);
    // header("location: index.php?error=none");	
	exit();
}
	
	
function submitOrder($conn, $userId, $message, $orderDate){
	$GLOBALS["userId"] = $userId;
	$GLOBALS["message"] = $message;
	$GLOBALS["orderDate"] = $orderDate;
	$sql = "INSERT INTO orders (userId, messageId, orderDateSend) VALUES (?, ?, ?);";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
	 	header("location: index.php?error=stmtfailed");
		exit();
	}
	
	mysqli_stmt_bind_param($stmt, "sss", $userId, $message, $orderDate);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
	exit();
}
	

	
	
	
	
	
	
	
	
	