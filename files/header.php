<!DOCTYPE html>
<html>

<head>
	<title>onMelody</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/password.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
	<nav style="border-radius:5px" class="navbar navbar-expand-lg navbar-light bg-info mb-5">
		<div class="container">

			<a class="navbar-brand text-light font-italic" href="index.php">online-Melody</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
	
			<div class="collapse navbar-collapse " id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<!-- <li class="nav-item">
						<a class="nav-link text-light" href="ALLkaroke.php">BGM</a>
					</li> -->
					<!-- <li class="nav-item">
						<a class="nav-link text-light" href="#">Genre</a>
					</li> -->
					<li class="nav-item">
						<a class="nav-link text-light" href="all_songs.php">All Musics</a>
					</li>
					<!-- <li class="nav-item">
						<a class="nav-link text-light" href="latest_tracks.php">Latest Tracks</a>
					</li> -->
	
					<li class="nav-item">
						<?php if (isset($_SESSION['user'])) { ?>
							<!-- <a class="nav-link text-danger" href="logount_process.php">Logout</a> -->
							<a class="nav-link text-light" href="my_account.php">My Account</a>
						<?php } else { ?>
							<a class="nav-link text-light" href="login.php">Login</a>
						<?php } ?>
	
					</li>
					<li class="nav-item">
						<a class="nav-link text-light" href="admin_song_upload.php">UPLOAD NEW MUSIC</a>
					</li>
				</ul>
				<div class="my-2 my-lg-0 row">
					<form method="post" action="./index.php" class="form-inline">
						<input class="form-control mr-sm-2" type="search" placeholder="Search" name="search_text" aria-label="Search">
						<button class="btn btn-outline-dark my-2 my-sm-0" name="search" type="submit">Search</button>
					</form>
					<?php if (isset($_SESSION['user'])) { ?>
							<a class="nav-link btn-danger ml-1"style="border-radius:15px" href=" logount_process.php">Logout</a>
						<?php }
						?>
				</div>
			</div>
		</div>
	</nav>
	<div class="container">
		<p class="float-right m-3 font-weight-bold text-secondary"> <?php if (isset($_SESSION['user'])) echo $_SESSION['user']['username']; ?></p>
	</div>
	<?php if (isset($_SESSION['message'])) { ?>
		<div class="alert alert-<?= $_SESSION['message']['type'] ?>  m-3">
			<?php
			echo ($_SESSION['message']['body']);
			unset($_SESSION['message']);
			?>
		</div>
	<?php	} ?>