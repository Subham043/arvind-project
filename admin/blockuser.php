<?php
session_start();
include('includes/db.php');
include '.././files/functions.php';


$user_id = $_POST['user_id'];
$status = $_POST['block'];
$res = mysqli_query($conn, "UPDATE users set block_status = $status where user_id ='$user_id' ");
if ($res) {
    $data = array('responce' => 'success', 'message' => 'blocked');
} else {

    $data = array('responce' => 'error', 'message' => 'failed');
}
echo json_encode($data);
