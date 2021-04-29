<?php
session_start();
include 'files/functions.php';
require_once("files/header.php");
$top_songs = get_all_songs($conn);
?>
<!-- 
[artist_id] => 5
[artist_name] => Jizzle
[artist_biography] => Jizzle was influenced by artist like Lil Wayn
[artist_details] => 
[artist_photo] => 1592902550_15623277316181_IMG_1965.jpeg
[song_id] => 2
[song_mp3] => 1592903501_24985636169454_Jizzle_-_Jealousy_(
[song_photo] => 1592903501_75222169227962_song_pic.png
[song_date] => 1592904725
[aritst_id] => 5
[song_name] => Jealousy 
[view_count] => 4
 -->
<div class="container">

    <ul class="list-group mt-md-3">
        <?php $i = 0;
        foreach ($top_songs as $key => $s) :
            if ($i > 9)
                break;

            $i++;
        ?>
            <li class="list-group-item">
                <div class="row">
                    <div class="col">
                        <img class="img-fluid rounded" width="100" src="uploads/<?php echo $s['song_photo']; ?>" alt="">
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-12">
                                <?php echo $s['song_name']; ?>
                            </div>
                            <div class="col-12">
                                <?php echo $s['artist_name']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="col">
                            <div class="row">

                                <div class="col-12">
                                    <?php echo get_song_downloads($conn, $s['song_id']); ?> Downloads
                                </div>
                                <div class="col-12">
                                    <?php echo get_song_views($conn, $s['song_id']); ?> Views
                                </div>
                                <div class="col-12">
                                    Uploaded by : <?php $sqll = mysqli_query($conn, "SELECT first_name,last_name from users where user_id='" . $s['user_id'] . "'");
                                                    $res = $sqll->fetch_assoc();
                                                    $name = $res['first_name'] . " " . $res['last_name'];
                                                    echo $name;
                                                    ?>
                                </div>
                                <div class="col-12">
                                    <?php echo get_likes($conn, $s['song_id']); ?> <i href="#" id="liked" class="fa fa-thumbs-up"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col text-center">
                        <a href="play.php?song=<?php echo ($s['song_id']); ?>" title=""><img width="60" class="mt-3" src="img/play.png" alt=""></a>
                    </div>
                </div>
            </li>


        <?php endforeach ?>

    </ul>




</div>


<?php require_once("files/footer.php"); ?>