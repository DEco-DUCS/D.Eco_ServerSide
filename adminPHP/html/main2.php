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
                tdCommonName = tr[i].getElementsByTagName("td")[1];
                tdScientificName = tr[i].getElementsByTagName("td")[2];
                tdTour = tr[i].getElementsByTagName("td")[7];
                tdDescription = tr[i].getElementsByTagName("td")[5];
                if (tdCommonName || tdScientificName) {
                  if (tdCommonName.innerHTML.toUpperCase().indexOf(filter) > -1 || tdScientificName.innerHTML.toUpperCase().indexOf(filter) > -1 || tdTour.innerHTML.toUpperCase().indexOf(filter) > -1 || tdDescription.innerHTML.toUpperCase().indexOf(filter) > -1) {
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
                /* overflow: hidden; */
                /* max-width: 400px;
                word-wrap: break-word; */
                white-space: pre-wrap; /* css-3 */
                white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
                white-space: -pre-wrap; /* Opera 4-6 */
                white-space: -o-pre-wrap; /* Opera 7 */
                word-wrap: break-word;
                }
            div.scrollable {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                overflow: auto;
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
            #description {
                width:500px;
                height: 50px;
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
            <input type="text" id="myInput" class="myInput" onkeyup="commonName()" placeholder="Search by Common Name, Scientfic Name, Description or Tree Tour">

    <?php
        include("../protected/config.php");

        $query = 'SELECT id, common_name, scientific_name, latitude, longitude, description, tour_bool FROM treeMapDB.treesTable;';
        $query .= 'SELECT filepath FROM treeMapDB.imageTable;';

        $tree=array(array());
        i=0;
        //multi querry
        if($db->multi_query($query))
        {
          //for first query, add data to an array
          $result = $db->store_result();
          while($row = $result->fetch_assoc()){
            $tree1[i]= array('id'=>$row["id"],'common_name'=>$row["common_name"],'scientific_name'=>$row["scientific_name"],'latitude'=>$row["latitude"],'longitude'=>$row["longitude"],'description'=>$row["description"],'tour_bool'=>$row["tour_bool"]);
            i = i + 1;
          }

          j=0;
          //for second query, add data to a different array
          $db->next_result();
          $result = $db->store_result();
          while($row = $result->fetch_assoc()){
            $tree2[j]=array('filepath'=>$row["filepath"]);
            j = j + 1;
          }

          $tree=$tree1+$tree2;

        }
        ?>
        </table>
    <?php
    }
    $db->close();
?>
        </div>
    </body>
</html>
