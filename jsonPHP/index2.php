<?php
include_once 'RnDphp/db_function.php';
$db = new DB_Functions();
$result = $db->getTour();
$c = array();
$d = array();
while($row = mysqli_fetch_row($result))
{
    $d['id'] = $row[0];
    $d['common_name'] = $row[1];
    $d['scientific_name'] = $row[2];
    $d['latitude'] = $row[3];
    $d['longitude'] = $row[4];
    $d['description'] = $row[5];

    array_push($c,$d);
}
echo json_encode($c);

  ?>
