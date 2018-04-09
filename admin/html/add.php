<?php
// including the database connection file
include_once("../protected/config.php");

// file upload extension to allow
$allowedExts = array("jpg", "jpeg", "gif","png",".png", "mp3", "mp4", "wma");
$extension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

//when submit occurs
if(isset($_POST['add']))
{
    $common_name=$_POST['common_name'];
    $scientific_name=$_POST['scientific_name'];
    $latitude=$_POST['latitude'];
    $longitude=$_POST['longitude'];
    $description=$_POST['description'];
    $tour_bool=$_POST['tour_bool'];
    $image=$_FILES["image"]["name"];

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
        $msgTest = "one";
        //file field is not empty
        if (!empty($_FILES["image"]["name"]) && !empty($_FILES["image"]['tmp_name'])) {
          $msgTest = "in if isset";
            if ((($_FILES["image"]["type"] == "video/mp4")
            || ($_FILES["image"]["type"] == "audio/mp3")
            || ($_FILES["image"]["type"] == "audio/wma")
            || ($_FILES["image"]["type"] == "image/jpg")
            || ($_FILES["image"]["type"] == "image/gif")
            || ($_FILES["image"]["type"] == "image/png")
            || ($_FILES["image"]["type"] == "image/jpeg"))
            //&& ($_FILES["file"]["size"] < 20000)
            && in_array($extension, $allowedExts)){
              $msgTest = "in type check";
                // upload error
                if ($_FILES["image"]["error"] > 0)
                    {
                    $msgError = "File Upload Error: " . $_FILES["image"]["error"];
                    }
                //correct file extension
                else{
                   //if file already exits
                    if (file_exists("upload/" . $_FILES["image"]["name"]))
                      {
                        $msgError = "File already exits: ".$_FILES["image"]["name"];
                      }
                    //new file to upload
                    else{
                      $msgTest = "in upload";
                        $filepath = 'upload/' . $image;


                        //save file in folder
                        move_uploaded_file($_FILES["image"]["tmp_name"],
                        $filepath);

                        //two queries
                        $sql = "INSERT INTO treeMapDB.treesTable (common_name, scientific_name, latitude, longitude, description, tour_bool) VALUES ('$common_name', '$scientific_name', '$latitude', '$longitude', '$description', '$tour_bool');";

                        $sql .= "INSERT INTO treeMapDB.imageTable (treeid, filepath) VALUES ((SELECT id FROM treeMapDB.treesTable WHERE common_name = '$common_name' AND scientific_name = '$scientific_name' AND filepath = '$filepath' AND longitude = '$longitude' AND latitude = '$latitude'),'$filepath');";

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
        //no file uploaded...
        else{
            //updating the trees table
            $result = mysqli_query($db, "INSERT INTO treeMapDB.treesTable (common_name, scientific_name, latitude, longitude, description, tour_bool) VALUES ('$common_name', '$scientific_name', '$latitude', '$longitude', '$description', '$tour_bool')");
        }

        $__DEBUG__ = false;
        if(!$__DEBUG__){
          //redirectig to the display page. In our case, it is index.php
          header("Location: main.php");
        }
        else{
          //error messages
          if (!$db) {
              $errorMessage = 'Connect Error (' . mysqli_connect_errno() . ')' . mysqli_connect_error();
              die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
          }else{
            $errorMessage = 'Connected... ' . mysqli_get_host_info($db) . "\n";
          }
        }
    }
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
          font-family: "Roboto", sans-serif;
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
        .add {
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
        .add:hover,.add:active,.add:focus {
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
        <h1>Add Tree</h1>
        <?php echo "<h2 class='error'>".$errorMessage.$msgTest.$msglocation.$error.$msglocation.$msgError.$msgCN.$msgSN.$msgLat.$msgLong."</h2>"; ?>

    <form name="add" method="post" action="add.php" enctype="multipart/form-data">
        <table border="0">
            <tr>
                <td>Common Name</td>
                <td><input type="text" name="common_name" placeholder="Required" class="input" <?php if (!empty($_POST['common_name'])) {echo "value='" . $_POST["common_name"] . "'";} ?>></td>
            </tr>
            <tr>
                <td>Scientific Name</td>
                <td><textarea type="text" rows="1" style="resize: none;" name="scientific_name" placeholder="Required" class="input"><?php if (!empty($_POST['scientific_name'])) {echo $_POST["scientific_name"];} ?></textarea></td>
            </tr>
            <tr>
                <td>Latitude</td>
                <td><input type="text" name="latitude" placeholder="Required" class="input" <?php if (!empty($_POST['latitude'])) {echo "value='" . $_POST["latitude"] . "'";} ?>></td>
            </tr>
            <tr>
                <td>Longitude</td>
                <td><input type="text" name="longitude" placeholder="Required" class="input" <?php if (!empty($_POST['longitude'])) {echo "value='" . $_POST["longitude"] . "'";} ?>></td>
            </tr>
            <tr>
                <td>Add Image</td>
                <td><input type="file" name="image" id="image" />
                    <br /></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><textarea type="text" rows="6" name="description" style="resize:none;"class="input"><?php if (!empty($_POST['description'])) {echo $_POST["description"];} ?></textarea></td>
            </tr>
            <tr>
                <td>21 Tree Tour</td>
                <td><textarea type="text" name="tour_bool" rows="1" style="resize:none;"class="input" placeholder="enter 1 or 0 (yes or no)"><?php if (!empty($_POST['tour_bool'])) {echo $_POST["tour_bool"];} ?></textarea></td>
            </tr>
            <tr>
                <td><input type="hidden" name="id" value="add"></td>
                <td><input type="submit" name="add" value="Add" class="add"></td>
            </tr>
        </table>
    </form>
        </div>
</body>
</html>
