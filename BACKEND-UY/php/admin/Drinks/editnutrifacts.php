<html>
<head><title>Using the Edit Statement</title></head>
<body>
    <?php
        $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
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
            echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>";
            // drinks info
            echo "<h3>Drinks info</h3>";
            echo "<input type='hidden' name='newMainID' value='".$getDrinksInfo["drinks_id"]."'>".$getDrinksInfo["drinks_id"]."<br />";
            echo "Name: <input type='text' name='newName' value='".$getDrinksInfo["names"]."' size='150'> <br />";
            echo "Price: <input type='number' name='newPrice' value='".$getDrinksInfo["price"]."' size='150' step=0.01> <br />";

            // Nutrition facts
            echo "<h3>Nutrition facts</h3>";
            echo "<input type='hidden' name='newID' value='".$getFacts["nutr_facts_id"]."'>".$getFacts["nutr_facts_id"]."<br />";
            echo "Description: <input type='text' name='newDesc' value='".$getFacts["desc"]."' size='150'> <br />";
            echo "Ingredients: <input type='text' name='newIngredients' value='".$getFacts["Ingredients"]."' size='100'> <br />";
            echo "Fat: <input type='text' name='newFat' value='".$getFacts["Fat"]."'><br />";
            echo "Calories: <input type='text' name='newCalories' value='".$getFacts["Calories"]."'><br />";
            echo "Carbs: <input type='text' name='newCarbs' value='".$getFacts["Carbs"]."'><br />";
            echo "Protein: <input type='text' name='newProtein' value='".$getFacts["Protein"]."'><br />";

            // quantity info
            echo "<h3>Stocks info</h3>";
            echo "<input type='hidden' name='stocksID' value='".$getStocks["stocks_id"]."'>".$getStocks["stocks_id"]."<br />";
            echo "Price: <input type='number' name='newQuantity' value='".$getStocks["quantity"]."' size='150'> <br />";

            echo "<input type='submit' name='save' value='Save'><br />";
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
            mysqli_query($conn, "UPDATE nutr_facts set `desc`='$newDesc', Ingredients='$newIngredients', Fat='$newFat', Calories='$newCalories', Carbs='$newCarbs', Protein='$newProtein'
                                WHERE nutr_facts_id='$newID'");

            // stocks update
            $stocksID = $_POST["stocksID"];
            $newQuantity = $_POST["newQuantity"];
            mysqli_query($conn, "UPDATE stocks set `quantity`='$newQuantity'
                                WHERE stocks_id='$stocksID'");

            // drinks update
            $newMainID = $_POST["newMainID"];
            $newName = $_POST["newName"];
            $newPrice = $_POST["newPrice"];
            mysqli_query($conn, "UPDATE drinks set `name`='$newName', `price`='$newPrice'
                                WHERE drinks_id='$newMainID'");

            echo "Record has been updated!";
        }
    ?>

    <hr>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    
    Select Nutrition Facts ID: 
    <select name="drinks_id">
        <?php
        $idQuery = mysqli_query($conn, "SELECT drinks_id FROM drinks");

        // Loop through the results and populate dropdown options
        while ($row = mysqli_fetch_assoc($idQuery)) {
            echo "<option value='" . $row['drinks_id'] . "'>" . $row['drinks_id'] . "</option>";
        }
        ?>
    </select>

    <input type="submit" name="enter" value="Enter" /><br /><br />
    </form>

    <a href="drinks-table.php">Back</a>

</body>
</html>