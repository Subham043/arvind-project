<?php
session_start();
include('includes/db.php');
include '.././files/functions.php';

if (isset($_GET['song_id'])) {
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
}

if (isset($_GET['karoke_id'])) {
    if ($_GET['karoke_id']) {
        $karoke_id = $_GET['karoke_id'];
        $action = $_GET['action'];
        $res = mysqli_query($conn, "UPDATE karoke set verify = '$action' where id ='$karoke_id' ");
        if ($res) {
        } else {

            $data = array('responce' => 'error', 'message' => 'failed');
        }
    }
    header('location:manage_karoke.php');
}
