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

			// $target_dir = __DIR__;
			// $target_file = $target_dir . $_FILES["song_photo"]["name"];
			// // echo __DIR__;exit;
			// $uploadOk = 1;
			// $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			// if (!move_uploaded_file($_FILES["song_photo"]["tmp_name"], $target_file)) {
			// 	echo "The file ". ( basename( $_FILES["song_photo"]["tmp_name"])). " has been uploaded.";
			// } else {
			// echo "Sorry, there was an error uploading your file.";
			// }
			// exit;

			$target_dir = "uploads/";

			$song_photo = time() . "_" . rand(100000, 10000000) . rand(100000, 10000000) . "_" . $_FILES["song_photo"]["name"];
			$song_photo = $_FILES["song_photo"]["name"];

			$song_photo = str_replace(" ", "_", $song_photo);
			$song_photo = urlencode($song_photo);


			$source = $_FILES["song_photo"]["tmp_name"];
			$destinatin = $target_dir . basename($song_photo);

			if (move_uploaded_file($source, $destinatin)) {
			} else {
				$song_photo = "";
			}
		}
	}


	if (isset($_FILES['song_mp3']['error'])) {
		if ($_FILES['song_mp3']['error'] == 0) {
			$target_dir = "./uploads/";

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

	$song_date = time();

	$song_name = $_POST['song_name'];
	$aritst_id = $_POST['aritst_id'];
	$songtype_id = $_POST['type_id'];

	$verify = 0;
	$SQL = "SELECT * FROM songs WHERE song_name like '".$song_name."' OR song_name like '%".$song_name."' OR song_name like '".$song_name."%'";
	$data = $conn->query($SQL);
	if ($data->num_rows > 0) {
		header("Location: admin_song_upload.php?error=Song already exists");
		die();
	}
	$SQL = "INSERT INTO songs(
						song_mp3,song_photo,aritst_id,song_name,verify,user_id,`type_id`
					)VALUES(
						'$song_mp3','$song_photo','$aritst_id','$song_name','$verify','$user_id','$songtype_id'
					)
				";

	if ($conn->query($SQL)) {
		message("New song was uploaded successfully.", "success");
	} else {
		$er = mysqli_error($conn);
		message($er . "Something went wrong while uploading New song.", "warning");
	}

	header("Location: admin_songs.php");
	die();
}

$artists = get_all_artists($conn, $user_id);
?>
<?php require_once("files/header.php"); ?>
<div class="container">

	<!-- 
		song_date		
 -->
	<div class="row pl-0">
		<?php include 'files/admin_side_bar.php'; ?>
		<div class="col-md-8">
		<?php if (!empty($_GET['error'])) { ?>
			<div class="alert alert-danger  m-3">
				<?php
				echo ($_GET['error']);
				?>
			</div>
		<?php	} ?>
			<h2>Uploading new song</h2>

			<form method="post" action="admin_song_upload.php" enctype="multipart/form-data">
				<div class="row">
					<div class="col">
						<label for="song_name">Song name</label>
						<input type="text" name="song_name" class="form-control" id="song_name" placeholder="Enter song name">
					</div>


					<div class="col">
						<label for="aritst_id">Artist name</label>
						<select name="aritst_id" required="" class="form-control">
							<option value=""></option>
							<?php foreach ($artists as $key => $a) : ?>
								<option value="<?php echo $a['artist_id']; ?>"><?php echo $a['artist_name']; ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<label for="type_id">Genre</label>
						<select class="form-control" required id="type_id" name="type_id">
							<option value="" selected>SELECT </option>
							<?php
							// $gen = mysqli_query($conn, "SELECT * from genre");
							// if (mysqli_num_rows($gen) > 0) {
							// 	while ($row = $gen->fetch_assoc()) {
							?>
							<option value="movies">Movies</option>
							<option value="pop">Pop</option>
							<option value="rock">rock</option>
							<option value="Melody">Melody</option>

							<!-- <option value="others">Others</option> -->
						</select>

					</div>
					<div class="col">
						<label for="song_photo">Song photo</label>
						<input type="file" name="song_photo" class="form-control" id="song_photo">
					</div>
				</div>



				<div class="row">
					<div class="col">
						<label for="song_mp3">Song mp3</label>
						<input type="file" accept=".mp3" name="song_mp3" class="form-control" id="song_mp3">
					</div>

				</div>
				<button type="submit" class="float-right mt-md-3 btn btn-lg btn-primary">Add new song</button>

			</form>

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