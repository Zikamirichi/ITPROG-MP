<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" type="text/css" href="../../../css/admin.css" />
    <title>Drinks</title>
    <style>
        table {
            border: 1px solid black;
        }

        td, th {
            border: 1px solid black;
            text-align: center;
            background-color: white;
        }

        tr th {
            background-color: #311712; 
            color: white;
        }

        hr {
            margin: 5%;
        }

        .back-button {
            background-color: white;
            color: #311712;
            border: 1px solid #CED3D7;
        }

        .back-button:hover {
            background-color: #D4471F;
            color: white;
        }

    </style>
</head>
<body>
        <div class="main-container">
        <div class="header">
            <img src="../../../images/logo-only.png" alt="Logo">
            EDIT DRINKS
        </div>
        <div class="content-box">
            <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Nutrition Facts ID</th>
                <th>Stocks</th>
            </tr>

            <?php
            $conn = mysqli_connect("localhost", "root", "", "mydb") or die ("Unable to connect!". mysqli_error($conn) );
            mysqli_select_db($conn, "mydb");
            $factsQuery = mysqli_query($conn, "SELECT d.*, s.quantity 
            FROM drinks d JOIN stocks s
                         ON   d.stocks_id = s.stocks_id
             ORDER BY drinks_id;");
            while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
                echo "<tr>";
                echo "<td>", $factsResult ["drinks_id"], "</td>";
                echo "<td>", $factsResult ["names"], "</td>";
                echo "<td>", $factsResult ["price"], "</td>";
                echo "<td>", $factsResult ["nutr_facts_id"], "</td>";
                echo "<td>", $factsResult ["quantity"], "</td>";
                echo "</tr>";
            }
            ?>
            </table>

    <?php
        $conn = mysqli_connect("localhost", "root", "", "mydb") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");

        if(isset($_POST["enter"])){
            // nutr enter
            $mainID = $_POST['drinks_id'];
            $drinksQuery = mysqli_query($conn, "SELECT * FROM drinks WHERE drinks_id='$mainID'");
            $getDrinksInfo = mysqli_fetch_array($drinksQuery);

            $stocksID = $getDrinksInfo['stocks_id'];
            $stocksQuery = mysqli_query($conn, "SELECT * FROM stocks WHERE stocks_id='$stocksID'");
            $getStocks = mysqli_fetch_array($stocksQuery);

            $id = $getDrinksInfo['nutr_facts_id'];
            $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id='$id'");
            $getFacts = mysqli_fetch_array($factsQuery);
            echo "<form method='post' action='".$_SERVER['PHP_SELF']."' enctype='multipart/form-data'>";
            // drinks info
            echo "<h3>Drinks info</h3>";
            echo "<input type='hidden' name='newMainID' value='$mainID'>";
            echo "Name: <input type='text' name='newName' value='".$getDrinksInfo["names"]."' size='150'> <br />";
            echo "Price: <input type='number' name='newPrice' value='".$getDrinksInfo["price"]."' size='150' step='0.01'> <br />";

            // Nutrition facts
            echo "<h3>Nutrition facts</h3>";
            echo "<input type='hidden' name='newID' value='$id'>";
            echo "Description: <input type='text' name='newDesc' value='" . $getFacts["desc"] . "' size='150' placeholder='Maximum of 44 characters' maxlength='44'> <br />";
            echo "Ingredients: <input type='text' name='newIngredients' value='" . $getFacts["Ingredients"] . "' size='10' placeholder='Maximum of 500 characters' maxlength='500'> <br />";
            echo "Fat (g) : <input type='number' name='newFat' value='" . $getFacts["Fat"] . "' min='0' step='0.1'><br />";
            echo "Calories (g) : <input type='number' name='newCalories' value='" . $getFacts["Calories"] . "' min='0' step='0.1'><br />";
            echo "Carbs (g) : <input type='number' name='newCarbs' value='" . $getFacts["Carbs"] . "' min='0' step='0.1'><br />";
            echo "Protein (g) : <input type='number' name='newProtein' value='" . $getFacts["Protein"] . "' min='0' step='0.1'><br />";

            // quantity info
            echo "<h3>Stocks info</h3>";
            echo "<input type='hidden' name='stocksID' value='$stocksID'>";
            echo "Quantity: <input type='number' name='newQuantity' value='".$getStocks["quantity"]."' size='150'> <br />";
            
            // Image
            echo "<h3>Image</h3>";
            echo '<img src="' . '../../../images/' . $getDrinksInfo['image_name'] . '" width="50">';
            echo "<br><br>";
            echo '<input type="file" name="newImage">';

            echo "<div class='save-box'>";
            echo "<input type='submit' name='save' value='Save'><br />";
            echo "</div>";
            echo "</form>";

                }

                if(isset($_POST["save"])){
                    // nutr update
                    $newID = $_POST["newID"];
                    $newDesc = $_POST["newDesc"];
                    $newIngredients = $_POST["newIngredients"];
                    $newFat = $_POST["newFat"];
                    $newCalories = $_POST["newCalories"];
                    $newCarbs = $_POST["newCarbs"];
                    $newProtein = $_POST["newProtein"];
                    mysqli_query($conn, "UPDATE nutr_facts SET `desc`='$newDesc', Ingredients='$newIngredients', Fat='$newFat', Calories='$newCalories', Carbs='$newCarbs', Protein='$newProtein'
                                        WHERE nutr_facts_id='$newID'");
                
                    // stocks update
                    $stocksID = $_POST["stocksID"];
                    $newQuantity = $_POST["newQuantity"];
                    mysqli_query($conn, "UPDATE stocks SET `quantity`='$newQuantity'
                                        WHERE stocks_id='$stocksID'");
                
                    // drinks update
                    $newMainID = $_POST["newMainID"];
                    $newName = $_POST["newName"];
                    $newPrice = $_POST["newPrice"];
                
                    // Handle image upload
                    if ($_FILES['newImage']['name']) {
                        $target_dir = __DIR__ . "/../../../images/";
                        $image = $_FILES['newImage']['name'];
                        $imageExt = pathinfo($image, PATHINFO_EXTENSION);
                
                        // Allow only .jpg files
                        if ($imageExt == "jpg") {
                            $target_file = $target_dir . basename($image);
                            move_uploaded_file($_FILES["newImage"]["tmp_name"], $target_file);
                
                            // Update database with new image name
                            mysqli_query($conn, "UPDATE drinks SET `names`='$newName', `price`='$newPrice', `image_name`='$image'
                                                WHERE drinks_id='$newMainID'");
                        } else {
                            echo "Only .jpg files allowed, please try again.";
                        }
                    } else {
                        echo "Error uploading image";
                    }
                }
                ?>

    <hr>

    <div class="select-box">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Select ID: 
    <select name="drinks_id">
        <?php
        $idQuery = mysqli_query($conn, "SELECT * FROM drinks");

        // Loop through the results and populate dropdown options
        while ($row = mysqli_fetch_assoc($idQuery)) {
            echo "<option value='" . $row['drinks_id'] . "'>" . $row['names'] . " (" . $row['drinks_id'] . ")</option>";
        }
        ?>
    </select>
    <br /><br />
    <a class="back-button" href="drinks-table.php">Back</a>
    <input type="submit" name="enter" value="Enter" /><br /><br />
    </form>

</body>
</html>