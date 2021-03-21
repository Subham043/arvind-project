<?php

$conn = mysqli_connect("localhost", "root", "", "hmusic");
if (isset($_POST['change'])) {
    $email = $_GET['email'];
    $res = mysqli_query($conn, "select password from register where username = '$email'");
    while ($row = mysqli_fetch_array($res)) $otp = $row['password'];
    $password = $_POST['pass'];
    $pass = password_hash($password, PASSWORD_DEFAULT);
    $opt_pass = $_['text_otp'];
    if ($otp == $opt_pass) {
        $res2 = mysqli_query($conn, "Update users set password = '$pass' where username = '$email' ");
        if ($res2) {
            echo "<script>alert('Password Changed Successfully..');
              window.location='./index.php'
              </script>";
        }
    }
}
require './files/header.php';
?>
<div style="vertical-align:center" class="container">

    <h3>Reset Password</h3>
    <hr />
    <div id="change_pass">
        <form method="post">
            <div class="form-group">
                <label for="text_otp">OTP</label>
                <input type="text" class="form-control" id="text_otp" required name="text_otp" placeholder="Enter OTP">
            </div>
            <div class="form-group">
                <label for="pass">New Password</label>
                <input type="password" class="form-control" required id="pass" name="pass" placeholder="">
            </div>
            <div class="form-group">
                <label for="cpass">Confirm Password</label>
                <input type="text" class="form-control" id="cpass" required name="cpass" placeholder="">
            </div>
            <div class="form-group">
                <p class="text-danger" id="msg"></p>
            </div>
            <div class="form-group">
                <button type="submit" id="change" name="change" class="btn btn-primary">Change Password</button>
            </div>
        </form>
    </div>

    <?php
    require './files/footer.php';
    ?>
    <script>
        $('#cpass').keyup(function() {
            var password = $('#pass').val();
            if (password != $(this).val()) {
                $('#msg').html("password does not match");
            } else {
                $('#msg').html("");
            }
        })
    </script>