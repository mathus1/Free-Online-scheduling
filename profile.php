<?php
 require_once 'core/init.php';
 include 'includes/head.php';
 include 'includes/navigation.php';
 is_logged_in();

 $user_id= $user_data['id'];


 			$name = ((isset($_POST['name']) && !empty($_POST['name']))?sanitize($_POST['name']) : $user_data['full_name']);
 			$email = ((isset($_POST['email']) && !empty($_POST['email']))?sanitize($_POST['email']) : $user_data['email']);
      $saved_image='';
      $dbpath = '';

      if (isset($_GET['delete_image'])) {

        $images = $user_data['image'];
        $image_url = $_SERVER['DOCUMENT_ROOT'].$images;
        unlink($image_url);//delete file
        unset($images); //remove the specific directory path
        mysqli_query($db,"UPDATE users SET image = '' WHERE id = '$user_id'");
        echo "<script>window.location.href='profile.php'</script>";
      }

        $saved_image = (($user_data['image'] != '')? $user_data['image'] : '');
  			$dbpath = $saved_image;

      if($_POST) {

        $tmpLoc= array();
        $uploadPath= array();
        $allowed = array('png', 'jpg', 'jpeg', 'gif','PNG');
        @$photo_count = count($_FILES['photo']['name']);
        if($photo_count > 0) {

          $name1 = $_FILES['photo']['name'];
          $nameArray = explode('.', $name1);
          $fileName = $nameArray[0];
          @$fileExt = $nameArray[1];
          $mime = explode('/', $_FILES['photo']['type']);
          $mimeType = $mime[0];
          @$mimeExt = $mime[1];
          $tmpLoc = $_FILES['photo']['tmp_name'];
          $fileSize = $_FILES['photo']['size'];
          $uploadName = $user_id.'.'.$fileExt;
          $uploadPath = $_SERVER['DOCUMENT_ROOT'].'/files/profileimg/'.$uploadName;


          if ($uploadName != $user_id.'.') {
            $dbpath .= '/files/profileimg/'.$uploadName;

            if(!in_array($fileExt, $allowed)) {
              @$errors[] .= 'O formato do arquivo deve ser png, jpg, jpeg, gif';
            }
          }

          if($fileSize > 15000000) {
            @$errors[] .= 'O tamanho da imagem deve estar abaixo de 15 megabytes.';
          }

        }

        if(!empty($errors)) {
  				$error=display_errors($errors);
  			} else {

          if($photo_count >0){
  				/* Upload file and insert into database. */
  				move_uploaded_file($tmpLoc,$uploadPath);

  			}

          mysqli_query($db,"UPDATE users SET  full_name='$name', email='$email', image='$dbpath' WHERE id = '$user_id'");

          echo "<script>window.location.href='profile.php'</script>";
        }}

?>
  <div class="w3-content w3-padding-32" style="max-width:600px;">
    <div class="w3-card-4 w3-round-xlarge w3-animate-zoom w3-center ">
      <form action="profile.php" method="POST" enctype="multipart/form-data" class="form-group">

<div class="w3-container">

  <h2 class="text-center">Profile settings</h2>
  <h4>Change Settings</h4>
  <div><?php echo @$error;?> </div>
<div class="form-group">
<label for="name">Name</label>
<input type="text" name="name" id="name"  value="<?php echo $name; ?>" class="form-control">
</div>
<div class="form-group">
<label for="email">Email</label>
<input type="text" name="email" id="email"  value="<?php echo $email; ?>" class="form-control" readonly>
</div>

<a href="change_password.php" class="w3-btn w3-blue" style="text-decoration:none">Change password</a>
</div>

<div class="w3-container w3-margin">
  <?php if ($saved_image !='') {
     ?>
     <img src="<?php echo $user_data['image'];?>" height="50" width="50" class="w3-bar-item w3-circle w3-margin"></img>
      <?php echo ((empty($user_data['image']))?'':''); ?>
    <a href="profile.php?delete_image=1" class="w3-btn w3-red" style="text-decoration:none;">Erase file</a>

  <?php  } else{ ?>
    <div class="row">
      <div class="col-md-2 col-lg-2 col-sm-2">
          <div class="mbri-user w3-xxlarge"></div><br>
      </div>
      <div class="col-md-10 col-lg-10 col-sm-10">
        <div class="file-upload">
          <div class="file-select">
            <div class="file-select-button" id="fileName">Change avatar</div>
            <div class="file-select-name" id="noFile">No avatar</div>
            <input type="file" name="photo" id="chooseFile">
          </div>
        </div>
          </div>

    </div>
  <?php }?>
</div>


<input type="submit"  value="Save" class="btn btn-primary w3-large" style="width:200px;" onclick=" $(this).button('loading');setTimeout(function () { $btn.button('reset');}, 1000);"><br>
</form>
</div>
</div>

<script>
$('#chooseFile').bind('change', function () {
  var filename = $("#chooseFile").val();
  if (/^\s*$/.test(filename)) {
    $(".file-upload").removeClass('active');
    $("#noFile").text("No file chosen...");
  }
  else {
    $(".file-upload").addClass('active');
    $("#noFile").text(filename.replace("C:\\fakepath\\", ""));
  }
});
</script>

  <?php include 'includes/footer.php'; ?>
