<?php require_once 'controllers/authController.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4 offset-md-4 form-div">
				<form action="signup.php" method="post">
					<h3 class="text-center">Register</h3>

					<?php if(count($errors) > 0): ?>
					<div class="alert alert-danger">
						<?php foreach($errors as $error): ?>
						<li><?php echo $error; ?></li>
						<?php endforeach; ?>			
					</div>
					<?php endif; ?>


					<div class="form-group">
						<label for="firstname">Your Name</label>
						<input type="text" name="firstname" class="form-control form-control-1g">
					</div>

					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" name="username" values="<?php echo $username; ?>" class="form-control form-control-1g">
					</div>

					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" values="<?php echo $email; ?>" class="form-control form-control-1g">
					</div>

					
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" class="form-control form-control-1g">
					</div>

					<div class="form-group">
						<label for="passwordConf">Confirm Password</label>
						<input type="password" name="passwordConf" class="form-control form-control-1g">
					</div>

					<div class="form-group">
						<label for="mobilenumber">Mobile Number</label>
						<input type="number" id="mobilenumber" maxlength="10" name="mobilenumber" class="form-control form-control-1g">
					</div>

					<div class="form-group">
						<button type="submit" name="signup-btn" class="btn btn-primary btn-block btn-lg">Sign Up</button>
					</div>

					<p class="text-center">Already a Member? <a href="login.php">Sign In</a></p>

				</form>
			</div>
		</div>
	</div>
</body>
</html>