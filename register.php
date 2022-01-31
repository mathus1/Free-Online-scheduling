

	<?php
		require_once 'core/init.php';
		include 'includes/head.php';
		include 'includes/navigation.php';


			if($_POST) {
				$name = @sanitize($_POST['name']);
				$email = @sanitize($_POST['email']);
				$password = @sanitize($_POST['password']);
				$confirmpassword = @sanitize($_POST['confirmpassword']);

				$errors = array();
				// validade email
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errors[] = 'Invalid email';
				}
			 //password is more than 6 characters
				if (strlen($password) < 6) {
					$errors[] = 'Password must be at least 6 characters long';
				}

				if($password != $confirmpassword){
					$errors[] = 'The new password and the confimation does not confer';
				}

				//check if email exists in the dtatabase
				$query = mysqli_query($db,"SELECT * FROM users WHERE email='$email'");
				$user = mysqli_fetch_assoc($query);
				$userCount = mysqli_num_rows($query);
				if($userCount > 0){
				$errors[] = 'This email already exists in our database';
				}

				$required = array('name', 'email', 'password', 'confirmpassword');
				foreach($required as $field) {
					if($_POST[$field] == '') {
						$errors[] = 'All fields with an anterisk are required!';
						break;
					}
				}

				if(!empty($errors)) {
					$error=display_errors($errors);
				} else {
					$hashed= password_hash($password,PASSWORD_DEFAULT);
					$insertSql = "INSERT INTO users (full_name, email, password, confirmed) VALUES ('$name','$email','$hashed','0')";
					mysqli_query($db,$insertSql);
					$_SESSION['sucess_flash'] = 'Registration completed!';
					echo "<script>window.location.href='login.php'</script>";
			}
		}
	?>


	<div class="container-fluid">
	<div class="main-content w3-animate-zoom bg-success text-center">
		<div class="col-md-4 text-center company__info">
			<img src="files/calendar.png" style="max-height:250px;" alt="">
			<h4 class="company_title">Online Scheduling tool</h4>
		</div>
		<div class="col-md-8 col-xs-12 col-sm-12 login_form ">
			<div class="w3-container w3-padding-16">
				<div class="w3-center">
					<h2>Register</h2>
				</div>
				<div>
					<form action="register.php" method="POST" class="form-group">
						<div>
							<input type="name"  name="name" id="name" value="<?php echo @$name;?>" class="form__input" placeholder="Name">
						</div>
						<div>
							<input type="email"  name="email" id="email" value="<?php echo @$email;?>" class="form__input" placeholder="Email">
						</div>
						<div>
							<input type="password"  name="password" id="password" value="" class="form__input" placeholder="Password">
						</div>
						<div>
							<input type="password"  name="confirmpassword" id="confirmpassword" value="" class="form__input" placeholder="Confirm password">
						</div>
						<div class="w3-padding">
								<input type="hidden" name="csrf" value="<?php echo $token1; ?>">
							<input type="submit" value="Submit" class="btn1">
						</div>
					</form>
				</div>
				<div class="row">
					<p>Do you already have an account? <a href="login.php">Login Here</a></p>
					<div><?php echo @$error;?></div>
				</div>
			</div>
		</div>
	</div>
</div>

	<script>
	$('form input').keydown(function (e) {
	    if (e.keyCode == 13) {
	        e.preventDefault();
	        return false;
	    }
	});
	</script>

	<?php
		include 'includes/footer.php';?>
