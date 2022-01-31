<?php
$connect = new PDO('mysql:host=localhost;dbname=calendar', 'root', '');
$connect->exec("set names utf8");
$db = mysqli_connect('127.0.0.1', 'root', '', 'calendar');
if(mysqli_connect_error()) {
  echo 'Database connection failed with following errors: '.mysqli_connect_error();
  die();
}

$db->set_charset("utf8");

function pretty_date($date){
  return date("d-m-Y H:i A",strtotime($date));
}

function pretty_date1($date){
  return date("d-m-Y",strtotime($date));
}

function pretty_date2($date){
  return date("H:i A",strtotime($date));
}

function display_errors($errors) {
  $display = '<ul  >';
  foreach($errors as $error) {
    $display .= '<li>'.$error.'</li>';
  }
  $display .= '</ul>';
  return $display;
}

function sanitize($dirty) {
  global $db;
  return mysqli_real_escape_string($db,htmlentities($dirty, ENT_QUOTES, "UTF-8"));
}

function sanitize2($dirty) {
  return htmlspecialchars($dirty, ENT_QUOTES, "UTF-8");
}

		@session_start();
		function login($userid){
			$_SESSION['userid'] = $userid;
			global $db;
			$date = date("Y-m-d H:i:s");
			mysqli_query($db,"UPDATE users SET last_login ='$date' WHERE id ='$userid'");


			$_SESSION['sucess_flash'] = 'You logged in';
			echo "<script>window.location.href='platform.php'</script>";

		}

		if(isset($_SESSION['sucess_flash'])){
			echo '<div class="w3-bottombar w3-topbar w3-border-green w3-pale-green text-center w3-large">'.$_SESSION['sucess_flash'].'</div>';
			unset($_SESSION['sucess_flash']);
		}
		if(isset($_SESSION['error_flash'])){
			echo '<div class="w3-bottombar w3-topbar w3-border-red w3-pale-red text-center w3-large">'.$_SESSION['error_flash'].'</div>';
			unset($_SESSION['error_flash']);
		}

    if(isset($_SESSION['userid'])){
			$userid = $_SESSION['userid'];
			$query = mysqli_query($db,"SELECT * FROM users WHERE id ='$userid'");
			$user_data= mysqli_fetch_assoc($query);
			$fn = explode(' ',$user_data['full_name']);
			$user_data['first'] = $fn[0];
    }

		function is_logged_in(){
			if (isset($_SESSION['userid'])) {
				return true;
			} else {
				$_SESSION['error_flash'] = 'You must log in to access the page';
				echo "<script>window.location.href='login.php'</script>";
			}
		}

		function isnot_logged_in(){
			if (isset($_SESSION['userid'])) {
				$_SESSION['error_flash'] = 'You are already logged in';
				echo "<script>window.location.href='platform.php'</script>";
			} else {
				return true;
			}
		}

		function has_permission(){
    global $user_data;
			$permissions = explode('.',$user_data['permissions']);
			if(in_array('admin',$permissions)){
				return true;
			}
			else {
				$_SESSION['error_flash'] = 'You do not have permission to access that page';
				echo "<script>window.location.href='index.php'</script>";
			}
		}

?>
