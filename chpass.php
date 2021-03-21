<?php
include 'files/functions.php';

if (isset($_POST['change_pass'])) {
    if ($_POST['change_pass'] == "my_account") {
        $oldpass = $_POST['oldpass'];
        $newpass = $_POST['newpass'];
        $newpass
            = password_hash($newpass, PASSWORD_DEFAULT);
        $username = $_POST['username'];
        $u = get_user_by_username($conn, $username);
        $hash = $u['password'];
        
        if (password_verify($oldpass, $hash)) {

            $update_pass = mysqli_query($conn, "update users set password='$newpass' where username='$username'");
            if ($update_pass) {
                $data = 'success';
            } else {
                $data = 'failure';
            }
        } else {
            $data = 'incorrect';
        }
        echo $data;
    }
}
