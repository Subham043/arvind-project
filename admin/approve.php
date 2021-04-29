<?php
session_start();
require "../Phpmailer/class.phpmailer.php";
require "../Phpmailer/class.smtp.php";
include('includes/db.php');
include '.././files/functions.php';
$username = $_GET['user_name'];
if (isset($_GET['song_id'])) {
    if ($_GET['song_id']) {
        $song_id = $_GET['song_id'];
        $action = $_GET['action'];

        if ($action == 1) {
            $subject = "Song Approved";
            $message = "Congrats !! Your song was approved";
        }
        $res = mysqli_query($conn, "UPDATE songs set verify = '$action' where song_id ='$song_id' ");
        if ($res) {

            phpmailsend($username, $subject, $message);
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
        if ($action == 1) {
            $subject = "BGM Approved";
            $message = "Congrats !! Your BGM was approved";
        }
        $res = mysqli_query($conn, "UPDATE karoke set verify = '$action' where id ='$karoke_id' ");
        if ($res) {
            phpmailsend($username, $subject, $message);
        } else {

            $data = array('responce' => 'error', 'message' => 'failed');
        }
    }
    header('location:manage_karoke.php');
}
