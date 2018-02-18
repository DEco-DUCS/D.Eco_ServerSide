<?php

  include_once 'RnDphp/db_function.php';
  $db = new DB_Functions();
  $result = $db->getTrees();
  $a = array();
  $b = array();
  while($row = mysqli_fetch_row($result))
  {
      $b['id'] = $row[0];
      $b['common_name'] = $row[1];
      $b['scientific_name'] = $row[2];
      $b['latitude'] = $row[3];
      $b['longitude'] = $row[4];

      array_push($a,$b);
  }
  echo json_encode($a);



  ?>