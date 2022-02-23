<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
	</head>
	<body>
        <?php 
            include("Assets/Extras/header.php");
            include("Assets/Extras/database.php");

            //This will get the user reservations from the database when the user successfully logins in to main page
            function getUserReservations($serverConn) {
                if (isset($_SESSION["username"])) {
                    $query = "SELECT reseverdbooks.ISBN, books.BookTitle, reseverdbooks.ReservedDate FROM reseverdbooks JOIN books USING (ISBN) WHERE reseverdbooks.username = '".$_SESSION["username"]."'";
                
                    $results = $serverConn->query($query);

                    if ($results->num_rows > 0) {
                        while($row = $results->fetch_assoc()) {
                            echo "<tr>". 
                                "<td>".$row["ISBN"]."</td>".
                                "<td>".$row["BookTitle"]."</td>".
                                "<td>".$row["ReservedDate"]."</td>".
                                "<td><a href=\"Assets/unreserve.php?ISBN=".$row["ISBN"]."\">Remove</a></td>".
                                "</tr>"; 
                        }
                    }
                    else {
                        echo "<tr><td colspan=\"4\" style=\"text-align: center;\">You currently have no reseverations</td></tr>";
                    }
                }
                else {
                    echo "<tr><td colspan=\"4\" style=\"text-align: center;\">Error: Username is not set</td></tr>";
                }
            }

            //This will search the database for the title/author/cateogry the user looking for in the books table
            function search($serverConn) {
                if (isset($_POST["titleAuthor"]) || isset($_POST["category"])) {
                    $search = $_POST["titleAuthor"];
                    $category = $_POST["category"];

                    
                    if ($category === "...") {
                        $query = "SELECT Books.ISBN, Books.BookTitle, Books.Author, Books.Edition, Books.Year, Category.CategoryDescription, Books.Reserverd FROM Books JOIN Category ON Category.CategoryID = Books.Category WHERE Books.BookTitle LiKE '%$search%' OR Books.Author LIKE '%$search%'";
                    }
                    else {
                        $query = "SELECT Books.ISBN, Books.BookTitle, Books.Author, Books.Edition, Books.Year, Category.CategoryDescription, Books.Reserverd FROM Books JOIN Category ON Category.CategoryID = Books.Category WHERE (Books.BookTitle LiKE '%$search%' OR Books.Author LIKE '%$search%') AND Books.Category LIKE '$category'";
                    }

                    $result = $serverConn->query($query);

                    if ($result->num_rows > 0) {
                        $rowCount = 0;

                        $_SESSION["books"] = null;
                        $_SESSION["numOfResults"] = null;

                        //Get the amount of pages are required to display all the results
                        $numOfResults = ceil($result->num_rows / 5);

                        $_SESSION["numOfResults"] = $numOfResults;
                        $totalBooks = array();
                        for ($i=0; $i < $numOfResults; $i++) { 
                            $tableRows = array();
                            $rowCount = 0;
                            while ($rowCount < 5) {
                                $row = $result->fetch_assoc();
                                $reseveLink = ($row["Reserverd"] === "N") ? "<td><a href=\"Assets/reserve.php?ISBN=".$row["ISBN"]."\">Reserve</a></td>": "<td></td>";
                                $tableRows[] = "<tr>". 
                                "<td>".$row["ISBN"]."</td>".
                                "<td>".$row["BookTitle"]."</td>".
                                "<td>".$row["Author"]."</td>".
                                "<td>".$row["Edition"]."</td>".
                                "<td>".$row["Year"]."</td>".
                                "<td>".$row["CategoryDescription"]."</td>".
                                "<td>".$row["Reserverd"]."</td>".
                                $reseveLink."</tr>"; 
                                $rowCount += 1;
                            }
                            $totalBooks[] = $tableRows;                            

                            
                        }
                        $_SESSION["books"] = $totalBooks;

                    }
                    
                    else {
                        $_SESSION["books"] = null;
                        $_SESSION["numOfResults"] = null;
                        echo "<tr><td colspan=\"8\" style=\"text-align: center;\">No results</td></tr>";
                    }
                }
            }
            
            //This gets the categories for the dropdown menu in the search area
            function getCatergories($serverConn) {
                $query = "SELECT * FROM Category";
                
                $result = $serverConn->query($query);
                
                if ($result->num_rows > 0) {
                    echo "<option value=\"...\"></option>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value=\"".$row["CategoryID"]."\">".$row["CategoryDescription"]."</option>";
                    }
                }
            }
            
            //This creates the links for the multiple pages on the bottom of the search results
            function createLinks($numOfLinks) {
                for ($i=0; $i < $numOfLinks; $i++) { 
                    echo "<a href=\"main.php?page=$i\">$i</a>";
                }
            }
            
            //This will redirect the user to the login page if they try to access the main page without logging in 
            if (!isset($_SESSION["username"])) {
                header("Location:  	/webD/Assignment/index.php");
            }
            

        ?>
        <div id="mainContent">
            <div id="tables">
            <div id="UserReservations">
                <h2>My Reservations</h2>
                <table>
                    <tr>
                        <th>ISBN</th>
                        <th>Book Title</th>
                        <th>Reserved Date</th>
                        <th>Remove</th>
                    </tr>
                    <?php 
                        getUserReservations($conn);
                    ?>
                </table>
            </div>
            <p id="test"></p>
            <div id="searchArea">
                <div id="SearchBox">
                    <h2>Search</h2>
                    <form method="POST" action="main.php?page=0">
                        <label for="titleAuthor">Search: </label>
                        <input id="titleAuthor" name="titleAuthor" type="text">
                        <label for="category">Category: </label>
                        <select name="category" id="category">
                            <?php
                                getCatergories($conn);
                            ?>
                        </select>
                        <input type="submit" value="Enter">
                    </form>
                </div>
                <div id="SearchResults">
                    <form method="POST">
                        <?php 
                        ?>
                    </form>
                    
                    <table>
                        <tr>
                            <th>ISBN</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Edition</th>
                            <th>Year</th>
                            <th>Category</th>
                            <th colspan="2">Reserved</th>
                        </tr>
                        <?php
                            search($conn);
                            
                            //This will display a set of 5 search result form the database
                            if(isset($_GET["page"]) && isset($_SESSION["books"])) {
                                $table = $_SESSION["books"][$_GET["page"]];
                                foreach ($table as $value) {
                                    echo $value;
                                }
                            } 
                        ?>
                    </table>
                    <div class="horizontalContainer">
                        <?php
                            if(isset($_SESSION["numOfResults"])) {
                                createLinks($_SESSION["numOfResults"]);
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <?php
            include("Assets/Extras/footer.php");
        ?>
	</body>
</html>