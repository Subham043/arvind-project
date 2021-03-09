<?php
session_start();
include("files/functions.php");
$username = $_POST['username'];
$password = $_POST['password'];
$u = get_user_by_username($conn, $username);
if (empty($u)) {
	message("Username does not exists on database", "danger");
	header('location: login.php');
	die();
}

$hash = $u['password'];
if (password_verify($password, $hash)) {
	if ($u['block_status'] == 0) {
		message("Your account was logged in successfully", "success");
		$_SESSION['user'] = $u;
		header("Location: my_account.php");
		die();
	} else {

		message("Your Account Was Blocked by the Admin,Please Contact for Further Procedures ", "danger");
		header('location: login.php');
	}
} else {
	message("You entered wrong password.", "danger");
	header('location: login.php');
	die();
}
