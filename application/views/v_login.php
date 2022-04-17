<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>

<!-- Bootstrap CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap-4.6.1/dist/css/bootstrap.min.css'); ?>">
<!-- Login CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css'); ?>">
<!-- Font Awesome -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
<!-- Icon -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/iconic/css/material-design-iconic-font.min.css'); ?>">

<!-- Jquery -->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
<!-- Bootstrap JS -->
<script type="text/javascript" src="<?php echo base_url('assets/bootstrap-4.6.1/dist/js/bootstrap.bundle.min.js'); ?>"></script>

<html lang="en">

<head>
	<meta charset="utf-8">
	<title>::<?= $tittle; ?>::</title>
</head>

<body>
	<div class="container-fluid">
		<div class="row justify-content-center align-items-center vh-100">
			<div class="col-12 col-sm-6 col-md-5">
				<form class="form-container needs-validation" action="<?php echo base_url('auth'); ?>" method="post" novalidate>
					<h2 class="text-center">LOGIN</h2>

					<?= $this->session->flashdata('message'); ?>

					<div class="form-group">
						<label for="email">Username</label>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="inputGroup-sizing-default" data-symbol="&#xf206;"></span>
							</div>
							<input type="text" class="form-control" id="username" name="username" placeholder="Type your username" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
							<div class="invalid-feedback">
								Username harap di isi
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="password">Password</label>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text" id="inputGroup-sizing-default" data-symbol="&#xf190;"></span>
							</div>
							<input type="password" class="form-control" id="password" name="password" placeholder="Type your password" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required>
							<div class="invalid-feedback">
								Kata sandi harap di isi
							</div>
						</div>
					</div>
					<!-- 
				<div class="form-group form-check">
					<input type="checkbox" class="form-check-input" id="exampleCheck1">
					<label class="form-check-label" for="exampleCheck1">Check me out</label>
				</div>
				 -->
					<div class="form-group">
						<a href="#">Lupa kata sandi?</a></br>
						<span class="txt3">Buat akun?&nbsp;</span><a href="#">Sign up</a>
					</div>
					<button type="submit" class="btn btn-primary btn-block">LOGIN</button>
				</form>
			</div>
		</div>
	</div>

	<script>
		// Example starter JavaScript for disabling form submissions if there are invalid fields
		(function() {
			'use strict';
			window.addEventListener('load', function() {
				// Fetch all the forms we want to apply custom Bootstrap validation styles to
				var forms = document.getElementsByClassName('needs-validation');
				// Loop over them and prevent submission
				var validation = Array.prototype.filter.call(forms, function(form) {
					form.addEventListener('submit', function(event) {
						if (form.checkValidity() === false) {
							event.preventDefault();
							event.stopPropagation();
						}
						form.classList.add('was-validated');
					}, false);
				});
			}, false);
		})();
	</script>
</body>

</html>