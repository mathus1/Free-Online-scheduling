<!-- Navbar -->


<section class=" menu cid-rrXFQ1mjxJ  bg-primary" once="menu" id="menu1-3">
	<nav class="navbar w3-content navbar-expand-lg navbar-dark bg-primary rounded w3-text-white" style="max-width:1100px;">
  <a class="navbar-brand" href="index.php">Team</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav w3-large" style="margin:0 auto;">
			<?php if (isset($_SESSION['userid'])) {
				$permissions = explode('.',$user_data['permissions']);
				if(in_array('admin',$permissions)){?>
      <li class="nav-item" style="padding:10px;">
        <a class="nav-link w3-text-white" href="users.php">Users</a>
      </li>
			<?php } ?>

			<li class="nav-item"  style="padding:10px;">
        <a class="nav-link w3-text-white" href="platform.php">Schedule</a>
      </li>

      <li class="nav-item dropdown"  style="padding:10px;">
        <a class="nav-link dropdown-toggle w3-text-white" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          	<?php echo ((empty($user_data['image']))?'<i class="fa fa-user-circle-o"></i>':'<img src="'.$user_data['image'].'" height="25" width="25" class="w3-bar-item w3-circle"></img>');?> <span><?php echo $user_data['first'];?></span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="profile.php">Profile</a>
          <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
      </li>

		<?php } else {?>
		<li class="nav-item" style="padding:10px;">
			<a class="nav-link w3-text-white" href="login.php">Login</a>
		</li>
			 <?php } ?>
    </ul>
  </div>
	</ul>
	</nav>
</section>
