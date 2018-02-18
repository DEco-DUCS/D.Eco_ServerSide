<?php
/**
 * DB operations functions
 */
include_once 'config.php';

class DB_Functions {

    private $db;
    private $con;

    //put your code here
    // constructor
    function __construct() {
        $this->con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
    }

    // destructor
    function __destruct() {

    }
 
    public function getTrees()
    {
     	$result = mysqli_query($this->con, "SELECT * FROM treeMapDB.treesTable");
        return $result;
    }
    
    public function getTour()
    {
     	$result = mysqli_query($this->con, "SELECT * FROM treeMapDB.treesTable WHERE tour_bool = 1");
        return $result;
    }
    
}
