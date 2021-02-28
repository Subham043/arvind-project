<?php
session_start();
error_reporting(0);
include('includes/db.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    $user_id = $_GET['userid'];
    $sql =  "DELETE From users where `user_id` = '$user_id'";
    $deleteuser = mysqli_query($conn, $sql);
    if ($deleteuser)
        echo "<script>alert('Deletion success');document.location = './dashboard.php'</script>";
    else
        echo "afadsf";
}
