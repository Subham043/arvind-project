<?php
include 'files/functions.php';
session_start();
if (!isset($_SESSION['user'])) {
	message("Login before you play a song.", "info");
	header("Location: login.php");
	die();
}




$user_id = $_SESSION['user']['user_id'];
if (isset($_GET['song']))
	$song_id = $_GET['song'];
record_view($conn, $song_id, $user_id);





require_once("files/header.php");

$song = $_GET['song'];
$s = get_top_song_by_song_id($conn, $song);
$artist_id = $s['artist_id'];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
	$(function() {
		var songid = $('#song_id').val();
		var user = $('#user').val();
		console.log(songid);
		console.log(user);
		$('#dislikedbody').prop("hidden", true);
		$('#likedbody').prop("hidden", false);

		$('#liked').click(function() {
			// x.classList.toggle("fa-thumbs-down");
			$('#dislikedbody').prop("hidden", false);
			$('#likedbody').prop("hidden", true);

			$.ajax({
				url: 'likes.php',
				type: 'post',
				data: {
					'liked': 1,
					'songid': songid,
					'user_id': user
				},
				cache: false,
				success: function(dataResult) {
					var dataResult = JSON.parse(dataResult);
					if (dataResult.statusCode == 200) {
						//	$("#butsave").removeAttr("disabled");
						//	$('#fupForm').find('input:text').val('');
						// $("#success").show();
						// $('#success').html('Data added successfully !');
					} else if (dataResult.statusCode == 201) {
						alert("Error occured !");
					}

				}
			});
		});

		$('#disliked').click(function() {
			// x.classList.toggle("fa-thumbs-down");
			$('#dislikedbody').prop("hidden", true);
			$('#likedbody').prop("hidden", false);
			$.ajax({
				url: 'likes.php',
				type: 'post',
				data: {
					'liked': 2,
					'songid': songid,
					'user_id': user
				},
				cache: false,
				success: function(dataResult) {
					var dataResult = JSON.parse(dataResult);
					if (dataResult.statusCode == 200) {
						//	$("#butsave").removeAttr("disabled");
						//	$('#fupForm').find('input:text').val('');
						// $("#success").show();
						// $('#success').html('Data added successfully !');
					} else if (dataResult.statusCode == 201) {
						alert("Error occured !");
					}

				}
			});
		});

	});
</script>
<!-- 
  [artist_id] => 4
    [artist_name] => Sheebah Karungi
    [artist_biography] => Sheebah Karungi is a Ugandan recording artist
    [artist_details] => 
    [artist_photo] => 1592129479_31892627593739_howwebiz_88e723f97cde9c8b7eb0aaaabcacbe51_1464525504_cover.jpg
    [song_id] => 8
    [song_mp3] => 1593507781_25997519201764_Harmonize_&_Sheebah_-_Follow_Me.mp3
    [song_photo] => 1593507781_69484951915618_shebah.png
    [song_date] => 
    [aritst_id] => 4
    [song_name] => Follow Me
    [view_count] => 0
    [download_count] => 0
 -->
<div class="container">
	<ul class="list-group mt-md-3">
		<li class="list-group-item">
			<h2 class="display-4"><?php echo $s['song_name']; ?></h2>
		</li>
		<li class="list-group-item">
			<div class="row">
				<div class="col-md-2">
					<img class="img-fluid rounded" src="uploads/<?php echo $s['song_photo']; ?>" alt="">
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-12">
							<b>Song Title:</b> <?php echo $s['song_name']; ?>
						</div>
						<div class="col-12">
							<b>Artist: </b>
							<a class="text-dark" href="artist.php?artist_id=<?= $s['artist_id'] ?>" title="<?= $a['artist_name'] ?>">
								<?php echo $s['artist_name']; ?>
							</a>
						</div>
						<div class="col-12">
							<b>Views: </b> <?php echo $s['view_count']; ?>
						</div>
						<div class="col-12">
							<b>Downloads: </b> <?php echo $s['download_count']; ?>
						</div>
						<input type="hidden" value="<?php echo $s['song_id'] ?>" name="" id="song_id">

						<input type="hidden" value="<?php echo $user_id ?>" name="" id="user">

						<div class="col-12">
							<?php
							if (check_likes($conn, $user_id, $song_id)) { ?>
								<span>liked</span>
							<?php
							}
							?>
							<span id="likedbody"><a href="#" id="liked" class="fa fa-thumbs-up"></a></span>
							<span id="dislikedbody"><a href="#" id="disliked" class="fa fa-thumbs-down"></a></span>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<audio controls>
						<source src="horse.ogg" type="audio/ogg">
						<source src="uploads/<?php echo $s['song_mp3']; ?>" type="audio/mpeg">
						Your browser does not support the audio element.
					</audio>
					<p id="success"></p>
				</div>
				<div class="col-md-2">
					<a class="btn btn-dark btn-block" target="_blank" href="download.php?song=<?= $song_id ?>">Download Mp3</a>
				</div>
			</div>
		</li>




	</ul>







	<!-- Latest songs -->
	<ul class="list-group mt-md-3">
		<li class="list-group-item">
			<h2 class="display-4">Related Songs</h2>
		</li>
		<li class="list-group-item">


			<!-- Laetset songs -->
			<div class="row">

				<?php
				$latest_songs = get_by_artist_id($conn, $artist_id);
				$i = 0;
				foreach ($latest_songs as $key => $s) :
					if ($i > 5)
						break;
					$i++; ?>

					<div class="col-6 col-md-2 rounded mt-3">
						<a href="play.php?song=<?php echo ($s['song_id']); ?>" title=""><img class="img-fluid rounded" src="uploads/<?php echo $s['song_photo']; ?>" alt=""></a>
					</div>

				<?php endforeach ?>
			</div>

		</li>

	</ul>


</div>

<?php require_once("files/footer.php"); ?>