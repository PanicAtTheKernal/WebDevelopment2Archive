<h2>Please wait for a moment, your book is being removed</h2>
<?php
include("database.php");

session_start();
$_SESSION["numOfResults"] = null;

if (isset($_GET["ISBN"]) && isset($_SESSION["username"])) {
    $ISBN = $_GET["ISBN"];
    $Username = $_SESSION["username"];

    $query = "DELETE FROM `reseverdbooks` WHERE `reseverdbooks`.`ISBN` = '$ISBN' AND `reseverdbooks`.`Username` = '$Username' ";
    $query2 = "UPDATE books SET reserverd='N' WHERE ISBN = '$ISBN'";

    if ($conn->query($query) === true && $conn->query($query2) === true) {
        echo "Success";
        $conn->close();
        header("Location:  	/webD/Assignment/main.php");
    }
    else {
        die("Error: " . $sql . "<br>" . $conn->error);
    }
}
else {
    die("Missing values");
}

?>