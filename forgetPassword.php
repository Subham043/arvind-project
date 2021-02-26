<?php
require './files/header.php';
?>

<div class="container ml-5  ">


    <h3>Reset Password</h3>
    <hr />
    <form method="POST">
        <div id="gen_otp">

            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control col-5" style="align-self: center;" id="exampleInputEmail1" name="email" required placeholder="Email">
            </div>
            <p id="msg"></p>
            <button type="submit" id="otp" name="otp" class="btn btn-primary">Get Otp</button>
            <hr />

        </div>

    </form>
</div>


</span>

<?php include './files/footer.php'; ?>



<?php
require "./Phpmailer/class.phpmailer.php";
require "./Phpmailer/class.smtp.php";
require './files/functions.php';
$conn = mysqli_connect("localhost", "root", "", "hmusic");

if (isset($_POST['otp'])) {
    $generator = "1357902468";
    $otp = "";

    for ($i = 1; $i <= 4; $i++) {
        $otp .= substr($generator, (rand() % (strlen($generator))), 1);
    }
    $email = $_POST['email'];
    $exist = mysqli_query($conn, "select * from users where username= '$email' ");
    $res = 0;
    if (mysqli_num_rows($exist) > 0) {
        $sql = "Update users set password = '$otp' where username = '$email'";
        $res = mysqli_query($conn, $sql);
    }
    if ($res) {
        $subject = "Karnataka Tourism Otp";
        $content = "Your Otp is : $otp";
        phpmailsend($email, $subject, $content);

        echo '<script>document.getElementById("msg").innerHTML = "Password sent to Your Email"</script>';

        echo "<script>
              window.location='./changepassword.php?email=$email'        </script>";
    } else {
        echo "<script>alert('User Does not Exist Please register..');
              window.location='./login.php'
              </script>";
    }
}


?>