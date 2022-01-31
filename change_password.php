<?php
 require_once 'core/init.php';
 include 'includes/head.php';
 include 'includes/navigation.php';
 is_logged_in();

 $hashed = $user_data['password'];
 $userid = $user_data['id'];
 $old_password= trim(@sanitize($_POST['old_password']));
 $password = trim(@sanitize($_POST['password']));
 $confirm = trim(@sanitize($_POST['confirm']));
 $newhashed = password_hash($password, PASSWORD_DEFAULT);


 if($_POST){
   //form validation
   if (empty($_POST['old_password']) OR empty($_POST['password']) OR empty($_POST['confirm'])) {
   $errors[] = 'Complete all fields';
   }

  //password is more than 6 characters
   if (strlen($password) < 6) {
     $errors[] = 'The password must be at least 6 characters';
   }
  if($password != $confirm){
    $errors[] = 'The new password and the confimation does not confer';
  }

  if (!password_verify($old_password, $hashed)) {
  $errors[] = 'Your old password does not match';
  }


   //check for errors
   if (!empty($errors)) {
     $error=display_errors($errors);
   }
   else {
     mysqli_query($db,"UPDATE users SET password ='$newhashed' WHERE id='$userid'");
     $_SESSION['sucess_flash'] = 'Password changed successfully!';
     echo "<script>window.location.href='profile.php'</script>";
   }
 }
 ?>
<div class="w3-content w3-padding-32" style="max-width:400px;">
<div class="w3-card-4 w3-round-xlarge w3-animate-zoom w3-center w3-container">
  <div><?php echo @$error;?> </div>
  <h2 class="text-center">Change password</h2><hr>
  <form action="change_password.php" method="POST">
    <div class="form-group">
      <label for="old_password">Old password</label>
      <input type="password" name="old_password" id="old_password" value="<?php echo $old_password;?>" class="form-control" >
    </div>
    <div class="form-group">
      <label for="password">New password:</label>
      <input type="password" name="password" id="password" value="<?php echo $password;?>" class="form-control" >
    </div>
    <div class="form-group">
      <label for="confirm">Confirm password:</label>
      <input type="password" name="confirm" id="confirm" value="<?php echo $confirm;?>" class="form-control">
    </div>
    <div class="form-group">
      <a href="profile.php" class="btn btn-primary w3-large">Cancel</a>
      <input type="submit"  value="Change" class="btn btn-primary w3-large">
    </div>
  </form>
  </div>
</div>


 <?php include 'includes/footer.php'; ?>
