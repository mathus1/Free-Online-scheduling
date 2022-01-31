<?php

//edit.php


require_once 'core/init.php';

if(isset($_POST["id"]))
{

  $idevent=sanitize($_POST['id']);
  $query = mysqli_query($db, "SELECT * FROM events WHERE id = '$idevent'");
  $search = mysqli_fetch_assoc($query);
  $adm = false;
  $permissions = explode('.',$user_data['permissions']);
  if(in_array('admin',$permissions)){  $adm = true; }
  if ($search['userid']==$user_data['id'] || $adm == true) {

 $query = "
 UPDATE events
 SET title=:title, description=:description, color=:color, userid=:userid
 WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => sanitize2($_POST['title']),
   ':description'  => sanitize2($_POST['description']),
    ':color'  => sanitize2($_POST['color']),
    ':userid'  => sanitize2($_POST['userid']),
   ':id'   => sanitize2($_POST['id'])
  )
 );
}}

?>
