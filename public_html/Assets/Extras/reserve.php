<?php
session_start();
?>
<h2>Please wait for a moment, your book is being reserved</h2>
<?php
include("database.php");

//This resets the data for the links on the bottom of the search results
$_SESSION["numOfResults"] = null;

if (isset($_GET["ISBN"]) && isset($_SESSION["username"])) {
    $ISBN = $_GET["ISBN"];
    $Username = $_SESSION["username"];
    
    $query = "INSERT INTO reseverdbooks (ISBN, Username) VALUES ('$ISBN', '$Username');";
    $query2 = "UPDATE books SET reserverd='Y' WHERE ISBN = '$ISBN'";
    
    if ($conn->query($query) === true && $conn->query($query2) === true) {
        echo "Success";
        $conn->close();
        echo "<script> location.replace(\"../../main.php\"); </script>";
    }
    else {
        die("Query didn't went through");
    }
}
else {
    die("Missing values");
}


?>