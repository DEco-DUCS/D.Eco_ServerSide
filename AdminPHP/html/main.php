<html>
    <head>
        <title>Manage Trees</title>
        <script>
            function commonName() {
              // Declare variables
              var input, filter, table, tr, td, i;
              input = document.getElementById("myInput");
              filter = input.value.toUpperCase();
              table = document.getElementById("myTable");
              tr = table.getElementsByTagName("tr");

              // Loop through all table rows, and hide those who don't match the search query
              for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                  } else {
                    tr[i].style.display = "none";
                  }
                }
              }
            }
            function scientificName() {
              // Declare variables
              var input, filter, table, tr, td, i;
              input = document.getElementById("myInput");
              filter = input.value.toUpperCase();
              table = document.getElementById("myTable");
              tr = table.getElementsByTagName("tr");

              // Loop through all table rows, and hide those who don't match the search query
              for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2];
                if (td) {
                  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                  } else {
                    tr[i].style.display = "none";
                  }
                }
              }
            }
        </script>

        <style type='text/css'>
            html {
                font-family: "Roboto", sans-serif;
            }
            .form {
                  position: relative;
                  z-index: 1;
                  background: #FFFFFF;
                  margin: 0 auto 100px;
                    max-width: 1230px;
                  padding: 45px;
                  text-align: center;
                  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
                }
            table {
                border-collapse: collapse;
                width: 100%;
                background: white;
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            th, td {
                border: 1px solid black;
                text-align: center;
            }
            th {
                height: 50px;
                padding-top: 2px;
                padding-bottom: 2px;
                padding-left: 15px;
                padding-right: 15px;
            }
            td {
                height: 50px;
                padding: 15px;
            }

            body {
                background: #8DC26F; /* fallback for old browsers */
            }
            a {
                color: #8DC26F;
            }
            a:hover {
                color: #43A047;
            }

            .delete:hover {
                color:red;
            }
            h1, h2{
                font-weight:normal;
            }
            .addTree, .logout {
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
            .addTree:hover,.addTree:active,.addTree:focus {
                color: #43A047;
            }
            img {
                width: 120px;
                height:inherit;
            }
            .addHeader {
                align-items: baseline;
            }
            #myInput {
                background-image: url('../photos/searchIcon.png'); /* Add a search icon to input */
                background-position: 10px 12px; /* Position the search icon */
                background-repeat: no-repeat; /* Do not repeat the icon image */
                width: 100%; /* Full-width */
                font-size: 16px; /* Increase font-size */
                padding: 12px 20px 12px 40px; /* Add some padding */
                border: 1px solid #ddd; /* Add a grey border */
                margin-bottom: 12px; /* Add some space below the input */
            }
            .logout {
                position:relative;
            }
        </style>
        <script>
            function confirmationDelete(anchor) {
                var conf = confirm('Are you sure want to delete this record?');
                if(conf)
                    window.location=anchor.attr("href");
                }
        </script>
    </head>
    <body>
        <h2><a href="logout.php" class="logout">Logout</a></h2>
        <div class="form">
            <img src="../photos/TeamLogo.png" alt="Team Logo">
        <h1>Manage Trees</h1>
            <h2><a href="add.php" class="addTree">Add Trees</a>
        </h2>
            <input type="text" id="myInput" class="myInput" onkeyup="commonName()" placeholder="Search for Common Names">
<!--            <input type="text" id="myInput" onkeyup="scientificName()" placeholder="Search for Scientific Names">-->
    <?php
        include("../protected/config.php");

//        // Check connection
//        if ($db->connect_error) {
//            die("Connection failed: " . $db->connect_error);
//        }
//        else {
//            echo "Connected successfully";
//        }

        $sql = "SELECT id, common_name, scientific_name, latitude, longitude, description, tour_bool FROM treeMapDB.treesTable";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            ?>
            <table id="myTable" class="table table-condensed">
                <tr>
                    <th>TreeID</th>
                    <th>Common Name</th>
                    <th>Scienctific Name</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>21 Tree Tour</th>
                    <th>Manage</th>
                </tr>
            <?php
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo '
                        <tr class="header">
                            <td id="id"/>' . $row["id"] . ' </td>
                            <td id="common_name"/>' . $row["common_name"] . ' </td>
                            <td id="scientific_name"/>' . $row["scientific_name"] . ' </td>
                            <td id="latitude"/>' . $row["latitude"] . ' </td>
                            <td id="longitude"/>' . $row["longitude"] . ' </td>
                            <td id="description"/>' . $row["description"] . ' </td>
                            <td id="image"/>image</td>
                            <td id="tour_bool"/>' . $row["tour_bool"] . ' </td>
                            <td><a href="edit.php?id=' . $row["id"] .'">Edit</a> | <a href="delete.php?id=' . $row["id"] .'" onClick="javascript:confirmationDelete('. $row["id"] .');return false;" class="delete">Delete</a></td>
                        </tr>';
        }
    } else {
        echo "0 results";
        ?>
        </table>
    <?php
    }
    $db->close();
?>
        </div>
    </body>
</html>
