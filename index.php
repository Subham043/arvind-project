<?php
session_start();
include 'files/functions.php';
require_once("files/header.php");
$top_songs = get_top_songs($conn);
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
	<?php
	if (isset($_POST['search'])) {
		// $txt_searched = $_POST['search_text'];
		// $ress = mysqli_query($conn,"SELECT id from genre where lower(type) = '$txt_searched'");
		// $type_id = $ress->fetch_assoc();

		// if(mysqli_num_rows($ress)>0)
		// {
		// $ssongs = mysqli_query($conn, "SELECT * FROM artist,songs
		// 	WHERE
		// 		songs.aritst_id = artist.artist_id and verify=1 and type_id = '".$type_id['id']."'
		// 	ORDER BY artist_name ASC");
		$ssongs = get_searched_songs($conn, $_POST['search_text']);
		if ($ssongs != false) {

	?>
			<div class="row mt-4 mb-2 ">
				<div class="col">
					<p class="h4 ">Results of Search : <?php echo $_POST['search_text']  ?></p>
				</div>
			</div>
			<hr>
			<ul class="list-group mt-md-3">
				<li class="list-group-item">
					<?php
					$c = 0;
					foreach ($ssongs as $key => $s) :

						$c++;
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
										<?php echo $s['download_count']; ?> Downloads
									</div>
									<div class="col-12">
										<?php echo $s['view_count']; ?> Views
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
							<a href="play.php?song=<?php echo ($s['song_id']); ?>" title=""><img width="100" src="img/play.png" alt=""></a>
						</div>
					</div>
				</li>


		<?php endforeach;
				} else {
					?><div class='container'><div class='row'><p class='h4 offset-1 text-dark m-4'>OOPs!! No songs Found</div></div>
					<hr>
				<?php }
			} else {


		?>
		<ul class="list-group mt-md-3">
			<li class="list-group-item">
				<h2 class="display-4">TOP 10 Hits</h2>
			</li>


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
										<?php echo $s['download_count']; ?> Downloads
									</div>
									<div class="col-12">
										<?php echo $s['view_count']; ?> Views
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



		<!-- Artists -->







		<!-- Latest songs -->
	<?php
			}
	?>
</div>


<?php require_once("files/footer.php"); ?>