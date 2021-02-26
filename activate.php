<?php
require './files/functions.php';
$conn = mysqli_connect("localhost", "root", "", "hmusic");
session_start();
if (isset($_GET['code'])) {
    $user = $_GET['uid'];
    $code = $_GET['code'];

    $query = mysqli_query($conn, "select * from users where user_id='$user'");
    $row = mysqli_fetch_array($query);

    if ($row['code'] == $code) {
        //activate account
        $ress = mysqli_query($conn, "update user sets verify='1' where user_id='$user'");
        if ($ress)
            message("Account Verfied Successfully", "success");
?>

        <!-- <div style="vertical-align:center">
        <p>Account Verified!</p>
        <p><a href="index.php"> click here </a>to Login Now</p>
</div> -->
<?php
    } else {
        echo "Something Went Wrong";
        header('location:login.php');
    }
} else {
    header('location:index.php');
}
?>