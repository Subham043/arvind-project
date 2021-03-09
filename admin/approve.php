<?php
session_start();
include('includes/db.php');
include '.././files/functions.php';


$song_id = $_POST['song_id'];
$action = $_POST['action'];
$res = mysqli_query($conn, "UPDATE songs set verify = '$action' where song_id ='$song_id' ");
if ($res) {
    $data = array('responce' => 'success', 'message' => 'approved');
} else {

    $data = array('responce' => 'error', 'message' => 'failed');
}
echo json_encode($data);
