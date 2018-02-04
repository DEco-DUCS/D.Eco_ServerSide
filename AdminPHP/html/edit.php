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
    $filepath=$_POST['filepath'];
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
        //updating the table
        $result = mysqli_query($db, "UPDATE treeMapDB.treesTable SET common_name='$common_name',scientific_name='$scientific_name',latitude='$latitude',longitude='$longitude',filepath='$filepath',description='$description',tour_bool='$tour_bool' WHERE id=$id");
        
        //redirectig to the display page. In our case, it is index.php
        header("Location: main.php");
    }
}
?>
<?php
//getting id from url
$id = $_GET['id'];
$query = 'SELECT id, common_name, scientific_name, latitude, longitude, filepath, description, tour_bool FROM treeMapDB.treesTable WHERE id=' . $id .'';
 
//selecting data associated with this particular id
$result = mysqli_query($db, $query);
 
while($row = mysqli_fetch_array($result))
{
    $id = $row['id'];
    $common_name=$row['common_name'];
    $scientific_name=$row['scientific_name'];
    $latitude=$row['latitude'];   
    $longitude=$row['longitude']; 
    $filepath=$row['filepath'];
    $description=$row['description'];
    $tour_bool=$row['tour_bool'];
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
                background: #4CAF50;
                border: 0;
                padding: 15px;
                color: #8DC26F;
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
        <h1>Update Tree: <?php echo $common_name; ?></h1>
        <?php echo "<h2 class='error'>".$msgCN.$msgSN.$msgLat.$msgLong."</h2>"; ?>
    
    <form name="edit" method="post" action="edit.php">
        <table border="0">
<!--
            <tr> 
                <td>id</td>
                <td><input type="text" name="id" value="<?php echo $id;?>" class="input" readonly></td>
            </tr>
-->
            <tr> 
                <td>Common Name</td>
                <td><input type="text" name="common_name" value="<?php echo $common_name;?>" class="input" placeholder="Required"></td>
            </tr>
            <tr> 
                <td>Scientific Name</td>
                <td><textarea type="text" name="scientific_name" class="input" placeholder="Required"><?php echo $scientific_name;?></textarea></td>
            </tr>
            <tr> 
                <td>Latitude</td>
                <td><input type="text" name="latitude" value="<?php echo $latitude;?>" class="input" placeholder="Required"></td>
            </tr>
            <tr> 
                <td>Longitude</td>
                <td><input type="text" name="longitude" value="<?php echo $longitude;?>" class="input" placeholder="Required"></td>
            </tr>
            <tr> 
                <td>Filepath</td>
                <td><textarea type="text" name="filepath" class="input"><?php echo $filepath;?></textarea></td>
            </tr>
            <tr> 
                <td>Description</td>
                <td><textarea type="text" name="description" class="input"><?php echo $description;?></textarea></td>
            </tr>
            <tr> 
                <td>21 Tree Tour</td>
                <td><textarea type="text" name="tour_bool" class="input" placeholder="0 no ; 1 yes"><?php echo $tour_bool;?></textarea></td>
            </tr>
            <tr>
                <td><input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
                <td><input type="submit" name="update" value="Update" class="update"></td>
            </tr>
        </table>
    </form>
        </div>
</body>
</html>