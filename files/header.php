<!DOCTYPE html>
<html>

<head>
	<title>onMelody</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>

<body>
	<nav style="border-radius:5px" class="navbar navbar-expand-lg navbar-light bg-info container">
		<a class="navbar-brand text-light font-italic" href="index.php">onMelody</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse " id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link text-light" href="#">Popular Tracks</a>
				</li>
				<li class="nav-item">
					<a class="nav-link text-light" href="#">Latest Tracks</a>
				</li>
				<li class="nav-item">
					<?php if (isset($_SESSION['user'])) { ?>
						<!-- <a class="nav-link text-danger" href="logount_process.php">Logout</a> -->
						<a class="nav-link text-light" href="my_account.php">My Account</a>
					<?php } else { ?>
						<a class="nav-link text-light" href="login.php">Login</a>
					<?php } ?>

				</li>
				<li class="nav-item">
					<a class="btn btn-primary btn-sm mt-1" href="admin_song_upload.php">UPLOAD NEW MUSIC</a>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0">
				<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
				<button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
				<?php if (isset($_SESSION['user'])) { ?>
					<a class="nav-link text-danger" href="logount_process.php">Logout</a>
				<?php } ?>
			</form>
		</div>
	</nav>

	<?php if (isset($_SESSION['message'])) { ?>
		<div class="alert alert-<?= $_SESSION['message']['type'] ?>  m-3">
			<?php
			echo ($_SESSION['message']['body']);
			unset($_SESSION['message']);
			?>
		</div>
	<?php	} ?>