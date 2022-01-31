<?php
 require_once 'core/init.php';
 include 'includes/head.php';
 include 'includes/navigation.php';
 isnot_logged_in();
 $email= trim(@sanitize($_POST['email']));
 $password= trim(@sanitize($_POST['password']));
 $csrf= @sanitize($_POST['csrf']);

 if($_POST){
   //form validation
   if (empty($_POST['email']) OR empty($_POST['password']) OR empty($_POST['csrf'])) {
   $errors[] = 'At least one of the fields is empty or there is a problem on the page';
   }
   // validade email
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
   $errors[] = 'Invalid email';
   }
  //password is more than 6 characters
   if (strlen($password) < 6) {
     $errors[] = 'Password must be at least 6 characters';
   }
   //check if email exists in the dtatabase
   $query = mysqli_query($db,"SELECT * FROM users WHERE email='$email'");
   $user = mysqli_fetch_assoc($query);
   $userCount = mysqli_num_rows($query);
   if($userCount < 1){
   $errors[] = 'This email does not exist in our database';
   }
   if(@$user['confirmed'] != 1){
   $errors[] = 'Confirm your account';
   }
   if (!password_verify($password, @$user['password'])) {
   $errors[] = 'Incorrect password';
   }

   //check for errors
      if (!empty($errors)) {
        $error=display_errors($errors);
      }
      else {
         if($_SESSION['csrf'] === $csrf){
              unset($_SESSION['csrf']);
              $user_id= $user['id'];
              login($user_id);

      }else {
              $_SESSION['error_flash'] = 'CSRF code error';
              echo "<script>window.location.href='login.php'</script>";
       }

      }

}
$token1 = md5(uniqid(rand(), true));
$_SESSION['csrf'] = $token1;
    ?>

    <div class="container-fluid">
		<div class="main-content w3-animate-zoom bg-success text-center">
			<div class="col-md-4 text-center company__info">
				<img src="files/calendar.png" style="max-height:250px;"  alt="">
				<h4 class="company_title">Online Scheduling tool</h4>
			</div>
			<div class="col-md-8 col-xs-12 col-sm-12 login_form ">
				<div class="w3-container w3-padding-16">
					<div class="w3-center">
						<h2>Log In</h2>
					</div>
					<div>
						<form action="login.php" method="POST" class="form-group">
							<div>
								<input type="email"  name="email" id="email" value="<?php echo $email;?>" class="form__input" placeholder="Email">
							</div>
							<div>
								<!-- <span class="fa fa-lock"></span> -->
								<input type="password"  name="password" id="password" value="<?php echo $password;?>" class="form__input" placeholder="Password">
							</div>
							<div class="w3-padding">
                  <input type="hidden" name="csrf" value="<?php echo $token1; ?>">
								<input type="submit" value="Submit" class="btn1">
							</div>
						</form>
					</div>
					<div class="row">
						<p>Don't have an account? (Access granted only for RICE members) <a href="register.php">Register Here</a></p>
            <div><?php echo @$error;?></div>
					</div>
				</div>
			</div>
		</div>
	</div>


 <?php include 'includes/footer.php'; ?>
