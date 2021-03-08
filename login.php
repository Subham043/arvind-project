<?php
session_start();
require_once("files/header.php"); ?>
<div class="container pt-2 pt-md-5">

	<div class="row ml-5 mb-3">
		<div class="col-md-6 mt-2">
			<h2 class="text-center text-dark mb-2">Login</h2>
			<form action="login_process.php" method="post">
				<div class="form-group">
					<label for="username">Email</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Enter Email">
				</div>
				<div class="form-group">
					<label for="Password">Password</label>
					<input type="password" class="form-control" id="Password" name="password" placeholder="Password">
				</div>
				<div class="form-group">
					<a href="forgetPassword.php" class="text-primary">Forget Password</a>
				</div>
				<button type="submit" class="btn btn-primary float-right mt-2">Login</button>
				<div class="form-group">
					<span class="text-primary">New User?</span><a href="register.php" >Click here to register</a>
				</div>
			</form>
		</div>

	</div>


</div>
<?php require_once("files/footer.php"); ?>