<?php
include 'files/functions.php';
session_start();
if (!isset($_SESSION['user'])) {
    message("Login before you play a song.", "info");
    header("Location: login.php");
    die();
}
$songid = $_POST['songid'];
$user_id = $_POST['user_id'];
// $songid = 14;
// $user_id = 14;
// $liked = 2;
$check_like = "SELECT * from likes where songs_id = '$songid' and user_id ='$user_id'";
$res = mysqli_query($conn, $check_like);

$liked = $_POST['liked'];
if ($liked == 1) {
    if (mysqli_num_rows($res) <= 0) {
        $sqllike = mysqli_query($conn, "Insert into likes(songs_id,user_id) Values('$songid','$user_id')");
        if ($sqllike)
            echo json_encode(array("statusCode" => 200));
        else
            echo json_encode(array("statusCode" => 201));
    }
}
if ($liked == 2) {
    if (mysqli_num_rows($res) > 0) {
        echo "<script>console.log('in')</script>";
        $sqldislike = mysqli_query($conn, "DELETE FROM likes where songs_id ='$songid' and `user_id`='$user_id'");
        if ($sqldislike)
            echo json_encode(array("statusCode" => 200));
        else
            echo json_encode(array("statusCode" => 201));
    }
}
