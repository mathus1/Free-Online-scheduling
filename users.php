<?php
	require_once 'core/init.php';
	is_logged_in();
	has_permission();
	include 'includes/head.php';
	include 'includes/navigation.php';


  if(isset($_GET['edit'])) {
    $edit_id = sanitize((int)$_GET['edit']);


    $usersResults = mysqli_query($db,"SELECT * FROM users WHERE id = '$edit_id'");
    $userq = mysqli_fetch_assoc($usersResults);

    $name = ((isset($_POST['name']) && !empty($_POST['name']))?sanitize($_POST['name']) : $userq['full_name']);
    $email = ((isset($_POST['email']) && !empty($_POST['email']))?sanitize($_POST['email']) : $userq['email']);
    $permissions = ((isset($_POST['permissions']) && !empty($_POST['permissions']))?sanitize($_POST['permissions']) : $userq['permissions']);
		  $confirmed = ((isset($_POST['confirmed']))?sanitize($_POST['confirmed']) : $userq['confirmed']);


  		if($_POST) {
  				mysqli_query($db,"UPDATE users SET  full_name='$name', email='$email', confirmed='$confirmed', permissions='$permissions' WHERE id = '$edit_id'");

  				echo "<script>window.location.href='users.php'</script>";
  				}




?>

<div class="w3-padding-32 w3-content ">
<div class="w3-sand profile_form w3-animate-zoom w3-card-4 w3-container">

  <h2 class="text-center">Profile Settings</h2>
  <h4>Profile information</h4>
  <form action="users.php?<?php echo ((isset($_GET['edit']))?'edit='.$edit_id : ''); ?>" method="POST">

    <div class="form-group">
    <label for="name">Name</label>
    <input class="form-control w3-border" type="text" name="name" id="name" value="<?php echo @$name; ?>">
    </div>
    <div class="form-group">
    <label for="email">Email</label>
    <input class="form-control w3-border" type="text" name="email" id="email" value="<?php echo @$email; ?>">
    </div>

    <div class="form-group">
      <label for="permissions">Permissions</label>
    <select class="form-control w3-border"   id="permissions" name="permissions">
      <option value="" <?php echo (($permissions == '')?' selected' : ''); ?>></option>
      <option value="editor" <?php echo (($permissions == 'editor')?' selected' : ''); ?>>viewer</option>
      <option value="admin.editor" <?php echo (($permissions == 'admin.editor')?' selected' : ''); ?>>admin</option>
    </select>
    </div>

		<div class="form-group">
		<label for="confirmed">Account confirmation</label>
	 <select class="form-control w3-border"  id="confirmed" name="confirmed">
			<option value="" <?php echo (($confirmed == '')?' selected' : ''); ?>></option>
			<option value="0" <?php echo (($confirmed == 0)?' selected' : ''); ?>>No</option>
			<option value="1" <?php echo (($confirmed == 1)?' selected' : ''); ?>>Yes</option>
		</select>
		</div>

      <button class="btn btn-default w3-right w3-large"><a href="users.php">Cancel</a></button>
      <input type="submit" value="Edit" class="btn btn-primary w3-right w3-large">

  </form>

</div>


</div>



<?php

}else {
  if (isset($_GET['delete'])) {
  	$delete_id = sanitize($_GET['delete']);
			$uquery = mysqli_query($db, "SELECT * FROM users WHERE id = '$delete_id'");
			$del = mysqli_fetch_assoc($uquery);
			$images = $del['image'];
			if ($images != '') {
				$image_url = $_SERVER['DOCUMENT_ROOT'].$images;
				unlink($image_url);//delete file
				unset($images); //remove the specific directory path
			}
			mysqli_query($db, "DELETE FROM events WHERE userid = '$delete_id'");
  		mysqli_query($db, "DELETE FROM users WHERE id = '$delete_id'");
  		$_SESSION['sucess_flash'] = 'User has been deleted';


  	echo "<script>window.location.href='users.php'</script>";
  }
?>
<section class="section-table cid-rs0FI1tDKr" id="table1-7">



  <div class="container container-table">
      <h2 >
          User list
      </h2>

      <div class="table-wrapper">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
                  <label class="">Search:</label>
                  <input class="form-control" id="myInput">
            </div>
          </div>
        </div>

        <div class="container scroll" style="height:600px; overflow:scroll;">
          <table class="table isSearch w3-centered" cellspacing="0">
            <thead>
              <tr class="table-heads ">

                <th class=""></th>
                <th class="">Name</th>
                <th class="">Email</th>
                <th class="">Join Date</th>
                <th class="">Last Login</th>
								<th class="">Permission</th>
								<th class="">Confirm</th>



             </tr>
            </thead>

            <tbody id="myTable">

              <?php
              $userquery = mysqli_query($db, "SELECT * FROM users ORDER BY full_name");
              while ($row = mysqli_fetch_assoc($userquery) ) { ?>
              <tr>

                <td class="">
                  <?php if($row['id'] != $user_data['id']){ ?>
                    <a href="users.php?delete=<?php echo $row['id'];?>" onclick="return confirm('Tem certeza de que quer remover o usuário?')" class="btn btn-default w3-large"><i class="fa fa-trash"></i></a><br>
                    <?php	} ?>
                    <a href="users.php?edit=<?php echo $row['id'];?>"  class="btn btn-default w3-large"><i class="fa fa-edit"></i></a><br>
                </td>
                <td><div class="w3-pale-green w3-margin w3-padding w3-round-large w3-card-2"><?php echo $row['full_name']; ?></div> <input class="w3-input w3-border" type="<?php echo ((@$_GET['edit']== $row['id'])?'text':'hidden');?>" name="name" id="<?php echo ((@$_GET['edit']== $row['id'])?'name':'')?>" value="<?php echo @$name; ?>"></td>
                <td><div class="w3-pale-green w3-margin w3-padding w3-round-large w3-card-2"><?php echo $row['email']; ?></div> <input class="w3-input w3-border" type="<?php echo ((@$_GET['edit']== $row['id'])?'text':'hidden');?>" name="email" id="<?php echo ((@$_GET['edit']== $row['id'])?'email':'')?>" value="<?php echo @$email; ?>"></td>
                <td><div class="w3-pale-green w3-margin w3-padding w3-round-large w3-card-2"><?php echo pretty_date1($row['join_date']);?></div></td>
                <td><div class="w3-pale-green w3-margin w3-padding w3-round-large w3-card-2"><?php if($row['last_login'] == '0000-00-00 00:00:00'){echo 'Never';}else{ echo pretty_date1($row['last_login']);}?></div></td>
								<td><div class="w3-pale-green w3-margin w3-padding w3-round-large w3-card-2"><?php echo $row['permissions'];?></div></td>
								<td><div class="w3-pale-green w3-margin w3-padding w3-round-large w3-card-2"><?php echo (($row['confirmed'] == 1)?'Confirmed':'Pending');?></div></td>
              </tr>
              <?php } ?>


             </tbody>
          </table>
        </div>

      </div>
    </div>



</section>


<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>


<?php
}
include 'includes/footer.php';
?>
