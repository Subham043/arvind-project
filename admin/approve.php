<?php
session_start();
include('includes/db.php');
include '.././files/functions.php';

if ($_GET['song_id']) {
    $song_id = $_GET['song_id'];
    $action = $_GET['action'];
    $res = mysqli_query($conn, "UPDATE songs set verify = '$action' where song_id ='$song_id' ");
    if ($res) {
    } else {

        $data = array('responce' => 'error', 'message' => 'failed');
    }
}
header('location:manage_songs.php');
