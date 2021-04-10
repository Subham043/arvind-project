<?php
session_start();
include 'files/functions.php';
if (isset($_SESSION['user'])) {
} else {
	header("Location: login.php");
	die();
}

if (isset($_POST['artist_name'])) {
	$file_name = "";

	if (isset($_FILES['artist_photo']['error'])) {
		if ($_FILES['artist_photo']['error'] == 0) {

			$target_dir = "uploads/";

			$file_name = time() . "_" . rand(100000, 10000000) . rand(100000, 10000000) . "_" . $_FILES["artist_photo"]["name"];

			$file_name = str_replace(" ", "_", $file_name);


			$source = $_FILES["artist_photo"]["tmp_name"];
			$destinatin = $target_dir . $file_name;

			if (move_uploaded_file($source, $destinatin)) {
			} else {
				$file_name = "";
			}
		}
	}

	$artist_name = strtolower($_POST['artist_name']);
	$artist_biography = $_POST['artist_biography'];
	$test = mysqli_query($conn, "SELECT * from artist where artist_name ='$artist_name'");
	if (mysqli_num_rows($test) == 0)
		$SQL = "INSERT INTO artist(artist_name,artist_biography,artist_photo)
			VALUES('{$artist_name}','{$artist_biography}','{$file_name}')";

	if ($conn->query($SQL)) {
		message("New artist was created successfully.", "success");
	} else {
		message(" Artist Already Added.", "warning");
	}

	header("Location: admin_artists.php");
	die();
}

?>
<?php require_once("files/header.php"); ?>
<!-- 
 			artist_details 	

 -->
<div class="container">


	<div class="row pl-0">
		<?php include 'files/admin_side_bar.php'; ?>
		<div class="col-md-8">
			<h2>Adding new artist</h2>

			<form method="post" action="artist_add_new.php" enctype="multipart/form-data">
				<div class="form-group">
					<label for="artist_name">Artist name</label>
					<input type="text" name="artist_name" class="form-control" id="artist_name" aria-describedby="emailHelp" placeholder="Enter artist name">
				</div>
				<div class="form-group">
					<label for="artist_biography">Artist biography</label>
					<textarea name="artist_biography" class="form-control" id="artist_biography"></textarea>
				</div>

				<div class="form-group">
					<label for="artist_photo">Artist photo</label>
					<input type="file" accept=".png,.jpg,.jpeg,.gif" name="artist_photo" class="form-control" id="artist_photo" placeholder="Enter email">
				</div>

				<button type="submit" class="float-right mt-md-3 btn btn-lg btn-dark">Add new artist</button>

			</form>

		</div>
	</div>

</div>


<?php require_once("files/footer.php"); ?>