<?php
	session_start();
	if ($_SESSION["redirect"] == TRUE) {
		$_SESSION["redirect"] = FALSE;
		// exit(header("Location: /main.php"));
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <link rel="stylesheet" href="Assets/CSS/style.css">
        <title>Sign in</title>
	</head>
	<body>
<?php 
			include("Assets/Extras/header.php");
		?>
		<div id="mainContent">
			<?php
				include("Assets/Extras/errorBox.php");
				include("Assets/Extras/database.php");
				?>
			<div id="errorBox">
<?php 
                    if ($conn->connect_error)  {
                        die("Connection Failed:" . $conn->connect_error . "<br>");
                    }

					 //Checks if the username and password are submitted in the from 
					if (isset($_POST["username"]) && isset($_POST["password"])) {
						$user = htmlspecialchars($_POST["username"]);
						$pass = htmlspecialchars($_POST["password"]);

						$query = "SELECT * FROM Users WHERE Username = '$user' AND Password = '$pass';";

						$result = $conn->query($query);

						//If the database return a single line then it means that the users credentials are in the database and forwards them to the main page
						if ($result->num_rows == 1) {
							$_SESSION["username"] = $user;
							$GLOBALS["redirect"] = TRUE;
							echo "<script> location.replace(\"main.php\"); </script>";
						}
						else {
							printErrorBox("Please check that username and password is correct.");
							$GLOBALS["redirect"] = FALSE;
						}
					}	
				?>
			</div>
			<div id="loginBox">
				<h2>Sign in</h2>
				<form method="post" action="index.php">
					<label for="username">Username: </label>
					<input name="username" id="username" type="text">
					<label for="password">Password: </label>
					<input name="password" id="password" type="password">
					<div class="horizontalContainer">
						<div class="spacer"></div>
						<input type="submit" value="Enter">
						<div class="spacer"></div>
						<input type="reset">	
						<div class="spacer"></div>
					</div>
					<a href="registration.php">New here? Click here.</a>
				</form>
			</div>
		</div>
<?php
            	include("Assets/Extras/footer.php");
			?>
	</body>
</html>