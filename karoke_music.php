<?php
session_start();
include 'files/functions.php';
if (isset($_SESSION['user'])) {
} else {
    header("Location: login.php");
    die();
}
$user_id = $_SESSION['user']['user_id'];
if (isset($_POST['song_name'])) {
    $file_name = "";

    $song_photo = "";
    $song_mp3 = "";

    if (isset($_FILES['song_photo']['error'])) {
        if ($_FILES['song_photo']['error'] == 0) {

            $target_dir = "uploads/karoke/";

            $song_photo = time() . "_" . rand(100000, 10000000) . rand(100000, 10000000) . "_" . $_FILES["song_photo"]["name"];

            $song_photo = str_replace(" ", "_", $song_photo);
            $song_photo = urlencode($song_photo);


            $source = $_FILES["song_photo"]["tmp_name"];
            $destinatin = $target_dir . $song_photo;

            if (move_uploaded_file($source, $destinatin)) {
            } else {
                $song_photo = "";
            }
        }
    }


    if (isset($_FILES['song_mp3']['error'])) {
        if ($_FILES['song_mp3']['error'] == 0) {

            $target_dir = "uploads/karoke/";

            $song_mp3 = time() . "_" . rand(100000, 10000000) . rand(100000, 10000000) . "_" . $_FILES["song_mp3"]["name"];

            $song_mp3 = str_replace(" ", "_", $song_mp3);
            $song_mp3 = urlencode($song_mp3);


            $source = $_FILES["song_mp3"]["tmp_name"];
            $destinatin = $target_dir . $song_mp3;

            if (move_uploaded_file($source, $destinatin)) {
            } else {
                $song_mp3 = "";
            }
        }
    }


    $song_name = $_POST['song_name'];
    $aritst_id = $_POST['aritst_id'];
    $songtype_id = $_POST['type_id'];
    // if ($_POST['txt_type_id'] != "") {
    //     $genreinsert = mysqli_query($conn, "Insert into genre (type) values('" . $_POST['txt_type_id'] . "')");
    // }
    $verify = 0;
    $SQL = "INSERT INTO `karoke`(`name`, `photo`, `music`,`user_id`,`verify`) VALUES('$song_name','$song_photo','$song_mp3','$user_id','0')
				";

    if ($conn->query($SQL)) {
        message("New Music was uploaded successfully.", "success");
    } else {

        message("Something went wrong while uploading New song.", "warning");
    }

    header("Location:karoke_music.php?op=view");
    die();
}

?>
<?php require_once("files/header.php"); ?>
<div class="container">

    <!-- 
		song_date		
 -->
    <div class="row pl-0">
        <?php include 'files/admin_side_bar.php'; ?>
        <div class="col-md-8">
            <h2>BGM</h2>

            <?php
            if ($_GET['op'] == 'view') {
            ?> <a style="float:right" href="karoke_music.php?op=upload" class="btn btn-primary btn-sm">Upload</a>

                <?php
                $getkaroke = mysqli_query($conn, "SELECT * from karoke where user_id='$user_id'");
                ?>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" style="width: 30%;">#</th>
                            <th scope="col">Name</th>
                            <th scope="col" style="width: 20%;">Music</th>
                            <th scope="col" style="width: 20%;">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($a = $getkaroke->fetch_assoc()) { ?>
                            <tr>
                                <th scope="row"><img class="img-fluid rounded" width="100%" src="uploads/karoke/<?php echo $a['photo']; ?>" alt=""></th>
                                <td><?php
                                    echo $a['name'];
                                    ?></td>
                                <td><audio controls>
                                        <source src="horse.ogg" type="audio/ogg">
                                        <source src="uploads/karoke/<?php echo $a['music']; ?>" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <!-- <a target="_blank" href="play.php?music=<?php echo ($a['id']); ?>" title="<?php echo $a['name']; ?> By <?php echo $a['artist_name']; ?>" class="btn btn-primary">View</a> -->
                                        <!-- <a href="admin_edit_song.php?music=<?php echo ($a['id']); ?>" class="btn btn-dark" title="">Edit</a> -->
                                        <a href="admin_delete_process.php?music=<?php echo ($a['id']); ?>" class="btn btn-danger" title="">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php
            }


            if ($_GET['op'] == "upload") {
            ?>
                <a style="float:right" href="karoke_music.php?op=view" class="btn btn-primary btn-sm">View Karoke</a>

                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="song_name">Name</label>
                        <input type="text" name="song_name" class="form-control" id="song_name" placeholder="Enter song name">
                    </div>



                    <!-- <div class="form-group">
                    <label for="type_id">Genre</label>
                    <select class="form-control" required id="type_id" name="type_id">
                        <option value="" selected>SELECT District</option>
                        <?php
                        $gen = mysqli_query($conn, "SELECT * from genre");
                        if (mysqli_num_rows($gen) > 0) {
                            while ($row = $gen->fetch_assoc()) {
                        ?><option value="<?php echo $row['id'] ?>"><?php echo $row['type'] ?></option>

                        <?php

                            }
                        }
                        ?>
                        <option value="others">Others</option>
                    </select>

                </div> -->
                    <div class="form-group">

                        <input type="text" name="txt_type_id" class="form-control" id="txt_type_id" hidden>

                    </div>

                    <div class="form-group">
                        <label for="song_photo">Music photo</label>
                        <input type="file" name="song_photo" class="form-control" id="song_photo">
                    </div>


                    <div class="form-group">
                        <label for="song_mp3">karoke mp3</label>
                        <input type="file" accept=".mp3" name="song_mp3" class="form-control" id="song_mp3">
                    </div>

                    <button type="submit" class="float-right mt-md-3 btn btn-lg btn-primary">Add</button>

                </form>
            <?php
            }
            ?>

        </div>
    </div>

</div>


<?php require_once("files/footer.php"); ?>
<script>
    $('#type_id').change(function() {
        var type = $(this).val();
        if (type == 'others')
            $('#txt_type_id').prop('hidden', false);
        else
            $('#txt_type_id').prop('hidden', true);
    })
</script>