<?php 
        include("../protected/config.php");
    
//        // Check connection
//        if ($db->connect_error) {
//            die("Connection failed: " . $db->connect_error);
//        }
//        else {
//            echo "Connected successfully";
//        }

    $sql = "SELECT * FROM treeMapDB.images";
    $sth = $db->query($sql);
    $result = mysqli_fetch_array($sth);
    $image = $result['imageBlob'];
    header("content-type: image/jpeg");
    echo $result['imageBlob'];
    echo 'hi';
    
//    $sql = "SELECT id,imageBlob FROM treeMapDB.images";
//    while($row = mysql_fetch_assoc($sql)){
//        $imageData = $row["imageBlob"];
//        //imageType = 
//    }
//    //make dynamic for all images
//    header("content-type: image/jpeg");
//    echo '<img src="data:image/jpeg;base64,'.$row['imageBlob'].'" alt="photo">';



//
//    if($result->num_rows > 0){
//        $imgData = $result->fetch_assoc();
//        
//        //Render image
//        header("Content-type: image/jpeg"); 
//        echo '<img src="data:image/jpeg;base64,'. base64_encode($imgData) .'" />';
//    }else{
//        echo 'Image not found...';
//    }


    $db->close();
?>
