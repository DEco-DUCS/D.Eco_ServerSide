<?php
// including the database connection file
include_once("../protected/config.php");

if(isset($_POST['update']))
{
    $id = $_POST['id'];

    $common_name=$_POST['common_name'];
    $scientific_name=$_POST['scientific_name'];
    $latitude=$_POST['latitude'];
    $longitude=$_POST['longitude'];
    $description=$_POST['description'];
    $tour_bool=$_POST['tour_bool'];

    // checking empty fields
    if(empty($common_name) || empty($scientific_name) || empty($latitude) || empty($longitude)) {
        if(empty($common_name)) {
            $msgCN = "Common name field is empty. <br />";
        }

        if(empty($scientific_name)) {
            $msgSN = "Scientific name field is empty. <br />";
        }

        if(empty($latitude)) {
            $msgLat = "Latitude field is empty. <br />";
        }
        if(empty($longitude)) {
            $msgLong = "Longitude field is empty. <br />";
        }
    } else {
      if(isset($_POST['Delete'])){
        $errorMessage = 'Delete? '.$_POST['Delete'];
        //get filepath variable
        $query = "SELECT filepath FROM treeMapDB.imageTable WHERE treeid='$id';";
        $result = mysqli_query($db, $query);
        while($row = mysqli_fetch_array($result))
        {
            $filepath=$row['filepath'];
        }

        $sqlDelete = "DELETE FROM treeMapDB.imageTable WHERE treeid='$id' AND filepath='$filepath'";
        $result = mysqli_query($db, $sqlDelete);
        unlink($filepath);
        $errorMessage = 'Delete???? '.$_POST['Delete'];
        $errorFilepath = 'Filepath: ' . $filepath;
      }
      if (!empty($_FILES["image"]["name"]) && !empty($_FILES["image"]['tmp_name'])) {
        $msgTest = "in if isset file";
          if ((($_FILES["image"]["type"] == "video/mp4")
          || ($_FILES["image"]["type"] == "audio/mp3")
          || ($_FILES["image"]["type"] == "audio/wma")
          || ($_FILES["image"]["type"] == "image/jpg")
          || ($_FILES["image"]["type"] == "image/gif")
          || ($_FILES["image"]["type"] == "image/png")
          || ($_FILES["image"]["type"] == "image/jpeg"))){
            $msgTest = "in type check";
              // upload error
              if ($_FILES["image"]["error"] > 0)
                  {
                  $msgError = "File Upload Error: " . $_FILES["image"]["error"];
                  }
              //correct file extension
              else{
                $msgTest = 'in else';
                 //if file already exits
                  if (file_exists("upload/" . $_FILES["image"]["name"]))
                    {
                      $msgError = "File already exits: ".$_FILES["image"]["name"];
                    }
                  //new file to upload
                  else{
                    $msgTest = "in upload";
                      $filepath = 'upload/' . $_FILES['image']['name'];

                      //save file in folder
                      move_uploaded_file($_FILES["image"]["tmp_name"],
                      $filepath);

                      //two queries
                      $sql = "UPDATE treeMapDB.treesTable SET common_name='$common_name',scientific_name='$scientific_name',latitude='$latitude',longitude='$longitude',description='$description',tour_bool='$tour_bool' WHERE id=$id;";

                      $sql .= "INSERT INTO treeMapDB.imageTable (treeid, filepath) VALUES ((SELECT id FROM treeMapDB.treesTable WHERE common_name = '$common_name' AND scientific_name = '$scientific_name' AND longitude = '$longitude' AND latitude = '$latitude'),'$filepath');";

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
                  }
                }
              }
            }
        else{
          //updating the table
          $result = mysqli_query($db, "UPDATE treeMapDB.treesTable SET common_name='$common_name',scientific_name='$scientific_name',latitude='$latitude',longitude='$longitude',description='$description',tour_bool='$tour_bool' WHERE id=$id");
        }
        //redirectig to main.php
        header("Location: main.php");
    }
}
?>
<?php
//getting id from url
$id = $_GET['id'];

//get data for single tree from the treeTable
$query = 'SELECT id, common_name, scientific_name, latitude, longitude, description, tour_bool FROM treeMapDB.treesTable WHERE id=' . $id .';';
$query .= 'SELECT filepath FROM treeMapDB.imageTable WHERE treeid = '.$id.';';


//multi querry
if($db->multi_query($query))
{
  //for first query, add data to an array
  $result = $db->store_result();
  $row = $result->fetch_assoc();
  $tree1= array('id'=>$row["id"],'common_name'=>$row["common_name"],'scientific_name'=>$row["scientific_name"],'latitude'=>$row["latitude"],'longitude'=>$row["longitude"],'description'=>$row["description"],'tour_bool'=>$row["tour_bool"]);

  //for second query, add data to a different array
  $db->next_result();
  $result = $db->store_result();
  $row = $result->fetch_assoc();
  $tree2=array('filepath'=>$row["filepath"]);

  $tree=$tree1+$tree2;

}

//to check to be sure there is a photo in the DB for the tree
if(!empty($tree["filepath"])){
    if(file_exists($tree["filepath"])){
    //create a html tag for an image
    $form = '
      <tr>
        <td>Current Image</td>
        <td><img src="'.$tree["filepath"].'"width="20" height="20"> </td>
        <td><input type="checkbox" name="Delete"/>Delete
      </tr><tr></tr>';
    }
    else{
      $form = '
      <tr>
        <td>Current Image</td>
        <td><textarea type="text" name="img" rows="2" style="resize:none;" class="input">Image not found at current filepath</textarea></td>
        <td><input type="checkbox" name="Delete"/>Delete existing filepath
      </tr><tr></tr>';

    }
}
else{
    //create an uneditable text box to indicate that there is no photo for the tree
    $form = '
      <tr><td>Current Image</td>
        <td><input type="text" name="filepath" value="None" readonly style="
        font-family: sans-serif;
        outline: 0;
        background: #f2f2f2;
        width: 100%;
        border: 0;
        margin: 0 0 15px;
        padding: 10px;
        box-sizing: border-box;
        font-size: 14px;"></td>
        <tr><td>Add Image</td>
        <td><input type="file" name="image" id="image" />
            <br/>
        </td>
        </tr>
      </tr>
        ';
}

?>
<html>
<head>
    <title>Edit Data</title>
    <style>
        html {
                font-family: "Roboto", sans-serif;
            }
        body {
                background: #8DC26F; /* fallback for old browsers */
            }
        .home {
                -webkit-appearance: button;
                -moz-appearance: button;
                appearance: button;

                text-decoration: none;
                color: initial;

                font-family: "Roboto", sans-serif;
                text-transform: uppercase;
                outline: 0;
                background: #e8e8e8;
                border: 0;
                padding: 15px;
                color: #98bf78;
                font-size: 14px;
                -webkit-transition: all 0.3 ease;
                transition: all 0.3 ease;
                cursor: pointer;
            }
            .home:hover,.home:active,.home:focus {
                color: #43A047;
            }
        h1 {
            font-weight:normal;
        }
        .form {
          position: relative;
          z-index: 1;
          background: #FFFFFF;
          max-width: 360px;
          margin: 0 auto 100px;
          padding: 45px;
          text-align: center;
          box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }
        table {
            width: 100%;
        }
        .form .input {
          font-family: sans-serif;
          outline: 0;
          background: #f2f2f2;
          width: 100%;
          border: 0;
          margin: 0 0 15px;
          padding: 10px;
          box-sizing: border-box;
          font-size: 14px;
        }
        img {
               width: 120px;
                height:inherit;
           }
        .update {
            font-family: "Roboto", sans-serif;
          text-transform: uppercase;
          outline: 0;
          background: #4CAF50;
          width: 100%;
          border: 0;
          padding: 15px;
          color: #FFFFFF;
          font-size: 14px;
          -webkit-transition: all 0.3 ease;
          transition: all 0.3 ease;
          cursor: pointer;
        }
        .update:hover,.update:active,.update:focus {
          background: #43A047;
        }
        td {
            text-align: center;
        }
        .error {
            color: #EF3B3A;
            font-weight: normal;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <h2><a href="main.php" class="home">Home</a></h2>

    <div class="form">
        <img src="../photos/TeamLogo.png" alt="Team Logo">
        <h1>Update Tree: <?php echo $tree['common_name']; ?></h1>
        <?php echo "<h2 class='error'>".$msgError.$error.$errorFilepath.$msgTest.$errorMessage.$msgCN.$msgSN.$msgLat.$msgLong."</h2>"; ?>

    <form name="edit" method="post" action="edit.php" enctype="multipart/form-data">
        <table border="0">
<!--
            <tr>
                <td>id</td>
                <td><input type="text" name="id" value="<?php echo $id;?>" class="input" readonly></td>
            </tr>
-->
            <tr>
                <td>Common Name</td>
                <td colspan=2><input type="text" name="common_name" value="<?php echo $tree['common_name'];?>" class="input" placeholder="Required"></td>
            </tr>
            <tr>
                <td>Scientific Name</td>
                <td colspan=2><textarea type="text" name="scientific_name" class="input" placeholder="Required" style="resize:none" rows="1"><?php echo $tree['scientific_name'];?></textarea></td>
            </tr>
            <tr>
                <td>Latitude</td>
                <td colspan=2><input type="text" name="latitude" value="<?php echo $tree['latitude'];?>" class="input" placeholder="Required"></td>
            </tr>
            <tr>
                <td>Longitude</td>
                <td colspan=2><input type="text" name="longitude" value="<?php echo $tree['longitude'];?>" class="input" placeholder="Required"></td>
            </tr>
        <?php echo $form; ?>
            <tr>
                <td>Description</td>
                <td colspan=2><textarea type="text" name="description" style="resize:none;" rows="6" class="input"><?php echo $tree['description'];?></textarea></td>
            </tr>
            <tr>
                <td>21 Tree Tour</td>
                <td colspan=2><input type="text" name="tour_bool" class="input" placeholder="enter 1 or 0 (yes or no)" value="<?php echo $tree['tour_bool'];?>"></td>
            </tr>
            <tr>
                <td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
                <td colspan=2><input type="submit" name="update" value="Update" class="update"></td>
            </tr>
        </table>
    </form>
        </div>
</body>
</html>
