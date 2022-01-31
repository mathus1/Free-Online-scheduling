<?php
require_once 'core/init.php';


if(isset($_POST["userid"]))
{

  $userid = sanitize($_POST["userid"]);

  $userResult = mysqli_query($db,"SELECT * FROM users WHERE id = '$userid'");
  $userx = mysqli_fetch_assoc($userResult);

  echo json_encode(array('name' => $userx['full_name'], 'image' => $userx['image']));

}
 ?>
