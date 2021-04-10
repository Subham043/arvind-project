<?php
session_start();
error_reporting(0);
include('includes/db.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    $user_id = $_GET['userid'];
    $deletedownload = mysqli_query($conn, "DELETE from downloads where user_id ='$user_id'");
    $deleteviews = mysqli_query($conn, "DELETE from views where user_id ='$user_id'");
    $deletelikes = mysqli_query($conn, "DELETE from likes where user_id ='$user_id'");
    $delesongs = mysqli_query($conn, "DELETE from songs where user_id = '$user_id'");
    $delekaroke = mysqli_query($conn, "DELETE from karoke where user_id = '$user_id'");
    $sql =  "DELETE From users where `user_id` = '$user_id'";
    $deleteuser = mysqli_query($conn, $sql);
    if ($deleteuser && $delesongs)
        echo "<script>alert('Deletion success');document.location = './dashboard.php'</script>";
    else
        echo "afadsf";
}
