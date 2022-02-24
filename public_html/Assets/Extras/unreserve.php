<?php
session_start();
?>
<h2>Please wait for a moment, your book is being removed</h2>
<?php
include("database.php");

$_SESSION["numOfResults"] = null;

if (isset($_GET["ISBN"]) && isset($_SESSION["username"])) {
    $ISBN = $_GET["ISBN"];
    $Username = $_SESSION["username"];

    $query = "DELETE FROM `reseverdbooks` WHERE `reseverdbooks`.`ISBN` = '$ISBN' AND `reseverdbooks`.`Username` = '$Username' ";
    $query2 = "UPDATE books SET reserverd='N' WHERE ISBN = '$ISBN'";

    if ($conn->query($query) === true && $conn->query($query2) === true) {
        echo "Success";
        $conn->close();
        echo "<script> location.replace(\"../../main.php\"); </script>";
    }
    else {
        die("Error: " . $sql . "<br>" . $conn->error);
    }
}
else {
    die("Missing values");
}

?>