<?php
session_start();
include './files/functions.php';
if (isset($_SESSION['user'])) {
	//echo("<pre>Logged in");
	//print_r($_SESSION['user']); 
} else {
	header("Location: login.php");
	die();
}

?>
<?php require_once("files/header.php"); ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<div class="container">

	<p class="h5 text-primary font-weight-bold" style="float:right;font-family: 'Times New Roman', Times, serif;"> <?php $name = $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name'];
																													echo $name
																													?></p>

	<div class="row">
		<div class="col-md-8">
			<h2>MY account</h2>

			<div class="container">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#cp">Change Password</a>
					</li>
					<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile">Profile</a>
					</li>
					<li class="nav-item offset-4"><?php if (isset($_SESSION['user'])) { ?>
							<a class="nav-link btn-outline-danger"style="border-radius:15px" href=" logount_process.php">Logout</a>
						<?php } else {
						?>
						<?php
											}
						?>
					</li>
				</ul>

				<div class="tab-content">

					<div class="tab-pane container active" id="cp">
						<form id="cpform">
							<h4 class="text-info">Change Password</h3>
								<div class="container">
									<div class="form-group">
										<label for="pass">Old Password</label>
										<span class="input-group-addon">
											<i class="fa fa-key"></i>
										</span>
										<input type="password" class="form-control" required id="oldpass" name="oldpass" placeholder="">
									</div>
									<div class="form-group">
										<label for="pass">New Password</label>
										<span class="input-group-addon">
											<i class="fa fa-key"></i>
										</span>
										<input type="password" class="form-control" required id="pass" name="pass" placeholder="">
									</div>
									<div class="form-group">
										<label for="cpass">Confirm Password</label>
										<span class="input-group-addon">
											<i class="fa fa-key"></i>
										</span>
										<input type="text" class="form-control" id="cpass" required name="cpass" placeholder="">
									</div>
									<div class="form-group">
										<p class="text-danger" id="msg"></p>
									</div>
									<input type="hidden" name="username" id="username" value="<?php echo $_SESSION['user']['username'] ?>">
									<div class="form-group">
										<button type="submit" id="change" name="change" class="btn btn-primary">Change Password</button>
									</div>
								</div>
						</form>
					</div>




					<div class="tab-pane container" id="profile">
						<table class="table">
							<thead>
								<th>Name</th>
								<th>Total songs Uploaded</th>
							</thead>
							<tbody>
								<?php
								$songs = count(get_all_songs($conn));

								?>
								<td><?php echo $_SESSION['user']['first_name'] . " " . $_SESSION['user']['last_name'] ?></td>
								<td><?php echo $songs ?></td>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<script>
	$(function() {
		$('#cpass').keyup(function() {
			var password = $('#pass').val();
			if (password != $(this).val()) {
				$('#msg').html("password does not match");
			} else {
				$('#msg').html("");
			}
		});

		$(document).on("click", "#change", function(e) {
			e.preventDefault();
			var oldpass = $('#oldpass').val();
			var pass = $('#pass').val();
			var username = $('#username').val();
			console.log(pass);
			console.log(oldpass);
			$.ajax({
				url: "chpass.php",
				type: "post",
				data: {
					oldpass: oldpass,
					newpass: pass,
					username: username,
					change_pass: "my_account"
				},
				success: function(data) {
					console.log("asdfasd");
					console.log(data);
					if (data == "success") {
						$('#cpform')[0].reset();
						Swal.fire('You Changed Password Successfully');

					} else {
						$('#cpform')[0].reset();
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: 'Password is incorrect'
						})
					}
				}

			});

		});
		$('#cpform')[0].reset();
	});
</script>

<?php require_once("files/footer.php"); ?>