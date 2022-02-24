<?php
    //This file incluedes the connection to the database which can be include in any file that needs to access the database
    $host = 'mysql';
    $user = 'root';
    $pass = '';
    $db =  'Assginment';
    $conn = new mysqli($host, $user, $pass, $db);
    
    if ($conn->connect_error)  {
        die("Connection Failed:" . $conn->connect_error . "<br>");
    }
?>