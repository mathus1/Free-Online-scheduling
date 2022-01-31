<?php

//load.php

require_once 'core/init.php';


$data = array();

$query = "SELECT * FROM events ORDER BY id";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'title'   => sanitize2($row["title"]),
  'description'   => sanitize2($row["description"]),
  'userid'   => $row["userid"],
  'color'   => $row["color"],
  'start'   => $row["start_event"],
  'end'   => $row["end_event"]
 );
}

echo json_encode($data);

?>
