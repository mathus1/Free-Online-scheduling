<?php

//update.php

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
 SET title=:title, description=:description, color=:color, start_event=:start_event, end_event=:end_event
 WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => sanitize2($_POST['title']),
   ':description'  => sanitize2($_POST['description']),
    ':color'  => sanitize2($_POST['color']),
   ':start_event' => sanitize2($_POST['start']),
   ':end_event' => sanitize2($_POST['end']),
   ':id'   => sanitize2($_POST['id'])
  )
 );
}}

?>
