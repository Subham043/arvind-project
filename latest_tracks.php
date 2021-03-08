<?php
session_start();
include 'files/functions.php';
require_once("files/header.php");
?>

<ul class="list-group mt-md-3">
    <li class="list-group-item">
        <h2 class="display-4">Latest Songs</h2>
    </li>
    <li class="list-group-item">


        <!-- Laetset songs -->
        <div class="row">

            <?php
            $latest_songs = get_latest_songs($conn);
            $i = 0;
            foreach ($latest_songs as $key => $s) :
                if ($i > 12)
                    break;
                $i++; ?>

                <div class="col-6 col-md-2 mt-3 rounded ">
                    <a href="play.php?song=<?php echo ($s['song_id']); ?>" title="<?php echo $s['song_name']; ?> By <?php echo $s['artist_name']; ?>"><img class="img-fluid rounded" src="uploads/<?php echo $s['song_photo']; ?>" alt=""></a>
                </div>

            <?php endforeach ?>
        </div>

    </li>

</ul>
<?php include './files/footer.php'?>
