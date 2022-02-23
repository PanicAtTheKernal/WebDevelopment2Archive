<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="Assets/CSS/style.css">
    <title>Registration</title>
  </head>
  <body>
    <?php 
      include("Assets/Extras/header.php");
      include("Assets/Extras/database.php");
    ?>
    <div id="mainContent">
      <div id="errorBox">
      <?php
				include("Assets/Extras/errorBox.php");
        
        function checkUserName($serverConn) {
          if (empty($_POST["username"])) {
            printErrorBox("Username is required<br>");
            return false;
          }
          else {
            $userTemp = htmlspecialchars($_POST["username"]);
            
            //Checks if the username is already in the database
            $query = "SELECT username FROM users WHERE username = '".$userTemp."'";
            $results =$serverConn->query($query);
            
            if ($results->num_rows > 0) {
              printErrorBox("Username is already taken<br>");
              return false;
            }
            else {
              //Checks if username if above the column size 
              if (strlen($userTemp) > $GLOBALS["commonLen"]) {
                echo "Username must be less than ".$GLOBALS["commonLen"]." characters<br>";
                return false;
              }
              else {
                return $userTemp;
              }
            }
                
          }
        }

        function checkPassword() {
          if (empty($_POST["password"]) && empty($_POST["passwordconformation"])) {
            printErrorBox("Password is required <br>");
            return false;
          }
          else {
            $passTemp = htmlspecialchars($_POST["password"]);
            $passConfromTemp = htmlspecialchars($_POST["passwordconformation"]);

            //Checks if password matchs with password conformation 
            if ($passConfromTemp === $passTemp) {
              //Checks if the length of the password is above the length of the column size
              if (strlen($passTemp) > $GLOBALS["passwordLen"]) {
                printErrorBox("Password must be ".$GLOBALS["passwordLen"]." characters in length <br>");
                return false;
              }
              else {
                return $passTemp;
              }
            }
            else {
              printErrorBox("Passwords do not match<br>");
              return false;
            }
          }
        }

        function basicVaildation($lineToVaildate, $size, $nameOfLine) {
          //Checks if the line is empty
          if (empty($lineToVaildate)) {
            printErrorBox("$nameOfLine can't be empty<br>");
            return false;
          }
          else {
            $lineTemp = htmlspecialchars($lineToVaildate);

            //Checks if the line above the size of the column 
            if (strlen($lineTemp) > $size) {
              printErrorBox("$nameOfLine must be less than $size");
              return false;
            }
            else {
              return $lineTemp;
            }
          }
        }

        function numericVaildation($lineToVaildate, $size, $nameOfLine) {
          //Checks if the line is empty
          if (empty($lineToVaildate)) {
            printErrorBox("$nameOfLine can't be empty<br>");
            return false;
          }
          else {
            $lineTemp = htmlspecialchars($lineToVaildate);

            //Checks if the line is numeric characters
            if(is_numeric($lineTemp)) {
              //Checks if the line above the size of the column 
              if (strlen($lineTemp) == $size) {
                return $lineTemp;
              }
              else {
                printErrorBox("$nameOfLine must be less than $size");
                return false;
              }
            }
            else {
              printErrorBox("$nameOfLine needs to be numeric characters");
              return false;
            }
          }
        }

        function totalVaildation($serverConn) {
          if (checkUserName($serverConn) === false) {
            return false;
          }

          if (checkPassword() === false) {
            return false;
          }

          if (basicVaildation($_POST["firstname"], $GLOBALS["commonLen"], "First name") === false) {
            return false;
          }

          if (basicVaildation($_POST["lastname"], $GLOBALS["commonLen"], "Last name") === false) {
            return false;
          }

          if (basicVaildation($_POST["addressline1"], $GLOBALS["addressLen"], "Address line 1") === false) {
            return false;
          }

          if (basicVaildation($_POST["addressline2"], $GLOBALS["addressLen"], "Addrss line 2") === false) {
            return false;
          }
          if (basicVaildation($_POST["city"], $GLOBALS["commonLen"], "City") === false) {
            return false;
          }

          if (numericVaildation($_POST["telephone"], $GLOBALS["numberLen"], "Telephone") === false) {
            return false;
          }

          if (numericVaildation($_POST["moblie"], $GLOBALS["numberLen"], "Moblie") === false) {
            return false;
          }

          return true;
        }

        $GLOBALS["totalNumOfCols"] = 10;
        $GLOBALS["numOfPassChecks"] = 0;
        $GLOBALS["commonLen"] = 30;
        $GLOBALS["addressLen"] = 50;
        $GLOBALS["passwordLen"] = 6;
        $GLOBALS["numberLen"] = 10;
        
        //Checks if the php script was called by POST
          if($_SERVER['REQUEST_METHOD'] == "POST") {
            if(totalVaildation($conn) === true) {
              $user = checkUserName($conn);
              $pass = checkPassword();
              $fname = basicVaildation($_POST["firstname"], $GLOBALS["commonLen"], "First name");
              $lname = basicVaildation($_POST["lastname"], $GLOBALS["commonLen"], "Last name");
              $add1 = basicVaildation($_POST["addressline1"], $GLOBALS["addressLen"], "Address line 1");
              $add2 = basicVaildation($_POST["addressline2"], $GLOBALS["addressLen"], "Addrss line 2");
              $city = basicVaildation($_POST["city"], $GLOBALS["commonLen"], "City");
              $telephone = numericVaildation($_POST["telephone"], $GLOBALS["numberLen"], "Telephone");
              $moblie = numericVaildation($_POST["moblie"], $GLOBALS["numberLen"], "Moblie");

              $sql = "INSERT INTO Users (Username, Password, FirstName, Surname, AddressLine1, AddressLine2, City, Telephone, Moblie) VALUES ('$user', '$pass', '$fname', '$lname', '$add1', '$add2', '$city', $telephone, $moblie)";

              if($conn->query($sql) === TRUE) {
                  echo "$user, your account has been created";
              } else {
                  echo "Error: " . $sql . "<br>" . $conn->error;
              }
            }
          }

          $conn->close();
      ?>
      </div>
      <div id="loginBox">
        <h2>Registration</h2>
        <form method="post" method="registration.php">
          <label for="username">Username: </label>
          <input type="text" name="username" id="username"><br>

          <label for="password">Password: </label>
          <input type="password" name="password" id="password"><br>
          <label for="passwordconformation">Password Conformation: </label>
          <input type="password" name="passwordconformation" id="passwordconformation"><br>

          <label for="firstname">First name: </label>
          <input type="text" name="firstname" id="firstname"><br>
          <label for="lastname">Surname: </label>
          <input type="text" name="lastname" id="lastname"><br>

          <label for="addressline1">Address line 1: </label>
          <input type="text" name="addressline1" id="addressline1"><br>
          <label for="addressline2">Address line 2: </label>
          <input type="text" name="addressline2" id="addressline2"><br>
          <label for="city">City: </label>
          <input type="text" name="city" id="city"><br>
          <label for="telephone">Telephone: </label>
          <input type="tel" name="telephone" id="telephone" placeholder="0123456789"><br>
          <label for="moblie">Moblie: </label>
          <input type="tel" name="moblie" id="moblie" placeholder="0123456789"><br>
          <div class="horizontalContainer">
            <div class="spacer"></div>
            <input type="submit" value="Enter">
            <div class="spacer"></div>
            <input type="reset">	
            <div class="spacer"></div>
          </div>
        </form>
      </div>
    </div>
    <?php
    include("Assets/Extras/footer.php");
    ?>
  </body>
</html>
