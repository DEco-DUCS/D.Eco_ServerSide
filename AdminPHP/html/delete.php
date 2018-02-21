<?php
//including the database connection file
include("../protected/config.php");

//getting id of the data from url
$id = $_GET['id'];

$query = "SELECT filepath FROM treeMapDB.imageTable WHERE treeid='$id';";
$result = mysqli_query($db, $query);
while($row = mysqli_fetch_array($result))
{
    $filepath=$row['filepath'];
}

//two queries
$sql = "DELETE FROM treeMapDB.treesTable WHERE id='$id';";

$sql .= "DELETE FROM treeMapDB.imageTable WHERE treeid='$id';";

//execute multi query
if (!$db->multi_query($sql)) {
    $error = "Multi query failed: (" . $db->errno . ") " . $db->error;
}

do {
    if ($res = $db->store_result()) {
        var_dump($res->fetch_all(MYSQLI_ASSOC));
        $res->free();
    }
} while ($db->more_results() && $db->next_result());

unlink($filepath);


//redirecting to the display page (index.php in our case)
header("Location:main.php");
?>
