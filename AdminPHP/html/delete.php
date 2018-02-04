<?php
//including the database connection file
include("../protected/config.php");
 
//getting id of the data from url
$id = $_GET['id'];
$query = 'DELETE FROM treeMapDB.treesTable WHERE id='.$id.''; 
 
//deleting the row from table
$result = mysqli_query($db, $query);
 
//redirecting to the display page (index.php in our case)
header("Location:main.php");
?>