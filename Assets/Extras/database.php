<?php
    //This file incluedes the connection to the database which can be include in any file that needs to access the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "AssginmentDB";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error)  {
        die("Connection Failed:" . $conn->connect_error . "<br>");
    }
?>