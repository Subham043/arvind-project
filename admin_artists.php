<?php
session_start();
if (isset($_SESSION['user'])) {
	//echo("<pre>Logged in");
	//print_r($_SESSION['user']); 
} else {
	header("Location: login.php");
	die();
}
include 'files/functions.php';
$user_id = $_SESSION['user']['user_id'];
$artists = get_all_artists($conn, $user_id);
?>
<?php require_once("files/header.php"); ?>

<div class="container">


	<div class="row">
		<?php include 'files/admin_side_bar.php'; ?>
		<div class="col-md-8">
			<h2>All Artists</h2>

			<a href="artist_add_new.php" class="btn btn-dark float-right mt-md-3 mb-md-3">
				Add new artist
			</a>

			<table class="table table-bordered">
				<thead class="thead-dark">
					<tr>
						<th scope="col" style="width: 15%;">#</th>
						<th scope="col">Name</th>
						<th scope="col" style="width: 20%;">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($artists as $key => $a) : ?>
						<tr>
							<th scope="row"><img class="img-fluid rounded-circle" width="100%" src="uploads/<?php echo $a['artist_photo']; ?>" alt=""></th>
							<td><?php
								echo $a['artist_name'];
								?></td>
							<td>
								<div class="btn-group btn-group-sm">
									<a href="artist.php?artist_id=<?php echo $a['artist_id'] ?>" class="btn btn-primary" title="">View</a>

									<a href="admin_artist_delete.php?artist_id=<?php echo $a['artist_id'] ?>" class="btn btn-danger" title="">Delete</a>
								</div>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>



		</div>
	</div>

</div>


<?php require_once("files/footer.php"); ?>