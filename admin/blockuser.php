<?php
session_start();
include('includes/db.php');
include '.././files/functions.php';


$user_id = $_GET['user_id'];
$status = $_GET['block'];
$res = mysqli_query($conn, "UPDATE users set block_status = $status where user_id ='$user_id' ");
if ($res) {
    // $data = array('responce' => 'success', 'message' => 'blocked');
   
} else {

    $data = array('responce' => 'error', 'message' => 'failed');
}
header('location:manage-users.php');
