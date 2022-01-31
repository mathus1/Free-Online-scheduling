<?php

//insert.php

require_once 'core/init.php';

if(isset($_POST["title"]))
{
 $query = "
 INSERT INTO events
 (title, description, userid, color, start_event, end_event)
 VALUES (:title, :description, :userid, :color, :start_event, :end_event)
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':title'  => sanitize2($_POST['title']),
   ':description' => sanitize2($_POST['description']),
   ':userid' => sanitize2($_POST['userid']),
   ':color' => sanitize2($_POST['color']),
   ':start_event' => sanitize2($_POST['start']),
   ':end_event' => sanitize2($_POST['end'])
  )
 );
}

?>
