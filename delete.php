<?php

//delete.php
require_once 'core/init.php';
if(isset($_POST["id"]))
{ $id= $_POST["id"];

  $idevent=sanitize($_POST['id']);
  $query = mysqli_query($db, "SELECT * FROM events WHERE id = '$idevent'");
  $search = mysqli_fetch_assoc($query);
  $adm = false;
  $permissions = explode('.',$user_data['permissions']);
  if(in_array('admin',$permissions)){  $adm = true;}

  if ($search['userid']==$user_data['id'] || $adm == true) {


 $query = "
 DELETE from events WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':id' => $_POST['id']
  )
 );
}}

?>
