<html>
<head><title>Using the Edit Statement</title></head>
<body>
    <?php
        $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");

        if(isset($_POST["enter"])){
        $id = $_POST["nutr_facts_id"];
        $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id='$id'");
        $getFacts = mysqli_fetch_array($factsQuery);
        echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>";
        echo "<input type='hidden' name='newID' value='".$getFacts["nutr_facts_id"]."'>".$getFacts["nutr_facts_id"]."<br />";
        echo "Description: <input type='text' name='newDesc' value='".$getFacts["desc"]."' size='150'> <br />";
        echo "Ingredients: <input type='text' name='newIngredients' value='".$getFacts["Ingredients"]."' size='100'> <br />";
        echo "Fat: <input type='text' name='newFat' value='".$getFacts["Fat"]."'><br />";
        echo "Calories: <input type='text' name='newCalories' value='".$getFacts["Calories"]."'><br />";
        echo "Carbs: <input type='text' name='newCarbs' value='".$getFacts["Carbs"]."'><br />";
        echo "Protein: <input type='text' name='newProtein' value='".$getFacts["Protein"]."'><br />";
        echo "<input type='submit' name='save' value='Save'><br />";
        echo "</form>";
        }

        if(isset($_POST["save"])){
        $newID = $_POST["newID"];
        $newDesc = $_POST["newDesc"];
        $newIngredients = $_POST["newIngredients"];
        $newFat = $_POST["newFat"];
        $newCalories = $_POST["newCalories"];
        $newCarbs = $_POST["newCarbs"];
        $newProtein = $_POST["newProtein"];
        mysqli_query($conn, "UPDATE nutr_facts set `desc`='$newDesc', Ingredients='$newIngredients', Fat='$newFat', Calories='$newCalories', Carbs='$newCarbs', Protein='$newProtein'
                            WHERE nutr_facts_id='$newID'");
        echo "Record has been updated!";
        }
    ?>

    <hr>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    
    Select Nutrition Facts ID: 
    <select name="nutr_facts_id">
        <?php
        $idQuery = mysqli_query($conn, "SELECT nutr_facts_id FROM nutr_facts");

        // Loop through the results and populate dropdown options
        while ($row = mysqli_fetch_assoc($idQuery)) {
            echo "<option value='" . $row['nutr_facts_id'] . "'>" . $row['nutr_facts_id'] . "</option>";
        }
        ?>
    </select>

    <input type="submit" name="enter" value="Enter" /><br /><br />
    </form>

    <a href="modnutrfacts.php">Back</a>

</body>
</html>