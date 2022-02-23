<?php
//This is for the error box you see in the login page and registration page
    function printErrorBox($errorMessage) {
        echo "<div id=\"errorMessage\">
        <p>$errorMessage</p>
        </div>";
    }
?>