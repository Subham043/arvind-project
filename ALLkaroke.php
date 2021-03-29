<?php
session_start();
include 'files/functions.php';
if (!isset($_SESSION['user'])) {
    message("Login before you play a song.", "info");
    header("Location: login.php");
    die();
}
require_once("files/header.php");



?><div class="container">
    <ul class="list-group mt-md-3">
        <li class="list-group-item">
            <h2 class="display-4">Karoke Musics</h2>
        </li>


        <?php $i = 0;
        $fetch = mysqli_query($conn, "SELECT * from karoke where verify=1");
        while ($s = $fetch->fetch_assoc()) {

            $i++;
        ?>
            <li class="list-group-item">
                <div class="row">
                    <div class="col">
                        <img class="img-fluid rounded" width="100" src="uploads/karoke<?php echo $s['photo']; ?>" alt="">
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-12">
                                <?php echo $s['name']; ?>
                            </div>

                        </div>
                    </div>
                    <div class="col">
                        <div class="col">
                            <div class="row">

                                <div class="col-12">
                                    Uploaded by : <?php $sqll = mysqli_query($conn, "SELECT first_name,last_name from users where  user_id='" . $s['user_id'] . "'");
                                                    $res = $sqll->fetch_assoc();
                                                    $name = $res['first_name'] . " " . $res['last_name'];
                                                    echo $name;
                                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <audio controls>
                            <source src="horse.ogg" type="audio/ogg">
                            <source src="uploads/karoke<?php echo $s['music']; ?>" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                </div>
            </li>


        <?php } ?>

    </ul>




</div><?php include './files/footer.php' ?>