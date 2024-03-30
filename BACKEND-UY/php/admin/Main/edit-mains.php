<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/admin.css" />
    <title>Main Dish</title>
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
            EDIT MAIN DISH
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
            $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
            mysqli_select_db($conn, "mydb");
                $factsQuery = mysqli_query($conn, "SELECT * FROM mains ORDER BY mains_id");
                while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
                    echo "<tr>";
                    echo "<td>", $factsResult ["mains_id"], "</td>";
                    echo "<td>", $factsResult ["name"], "</td>";
                    echo "<td>", $factsResult ["price"], "</td>";
                    echo "<td>", $factsResult ["nutr_facts_id"], "</td>";
                    echo "<td>", $factsResult ["stocks_id"], "</td>";
                    echo "</tr>";
                }
            ?>
            </table>
        
            <?php
$conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
mysqli_select_db($conn, "mydb");

if(isset($_POST["enter"])){
    // nutr enter
    $mainID = $_POST['mains_id'];
    $mainsQuery = mysqli_query($conn, "SELECT * FROM mains WHERE mains_id='$mainID'");
    $getMainsInfo = mysqli_fetch_array($mainsQuery);

    $stocksID = $getMainsInfo['stocks_id'];
    $stocksQuery = mysqli_query($conn, "SELECT * FROM stocks WHERE stocks_id='$stocksID'");
    $getStocks = mysqli_fetch_array($stocksQuery);

    $id = $getMainsInfo['nutr_facts_id'];
    $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id='$id'");
    $getFacts = mysqli_fetch_array($factsQuery);
    
    echo "<form method='post' action='".$_SERVER['PHP_SELF']."'>";
    // mains info
    echo "<h3>Mains info</h3>";
    echo "<input type='hidden' name='newMainID' value='".$getMainsInfo["mains_id"]."'>";
    echo "Name: <input type='text' name='newName' value='".$getMainsInfo["name"]."' size='150'> <br />";
    echo "Price: <input type='number' name='newPrice' value='".$getMainsInfo["price"]."' size='150' step=0.01> <br />";

    // Nutrition facts
    echo "<h3>Nutrition facts</h3>";
    echo "<input type='hidden' name='newID' value='".$getFacts["nutr_facts_id"]."'>";
    echo "Description: <input type='text' name='newDesc' value='".$getFacts["desc"]."' size='150' placeholder='Maximum of 44 characters' maxlength='44'> <br />";
    echo "Ingredients: <input type='text' name='newIngredients' value='".$getFacts["Ingredients"]."' size='10' placeholder='Maximum of 500 characters' maxlength='500'> <br />";
    echo "Fat (g) : <input type='number' name='newFat' value='".$getFacts["Fat"]."' min='0' step='0.1'><br />";
    echo "Calories (g) : <input type='number' name='newCalories' value='".$getFacts["Calories"]."' min='0' step='0.1'><br />";
    echo "Carbs (g) : <input type='number' name='newCarbs' value='".$getFacts["Carbs"]."' min='0' step='0.1'><br />";
    echo "Protein (g) : <input type='number' name='newProtein' value='".$getFacts["Protein"]."' min='0' step='0.1'><br />";

    // quantity info
    echo "<h3>Stocks info</h3>";
    echo "<input type='hidden' name='stocksID' value='".$getStocks["stocks_id"]."'>";
    echo "Quantity: <input type='number' name='newQuantity' value='".$getStocks["quantity"]."' size='150'> <br />";
    echo "<div class=save-box>";
    echo "<input type='submit' name='save' value='Save'<br />";
    echo "</div>";
    echo "</form>";
}

if(isset($_POST["save"])){

    $mainID = $_POST['newMainID']; 
    $stocksID = $_POST['stocksID'];
    $id = $_POST['newID'];

    // nutr update
    $newDesc = $_POST["newDesc"];
    $newIngredients = $_POST["newIngredients"];
    $newFat = $_POST["newFat"];
    $newCalories = $_POST["newCalories"];
    $newCarbs = $_POST["newCarbs"];
    $newProtein = $_POST["newProtein"];
    mysqli_query($conn, "UPDATE nutr_facts set `desc`='$newDesc', Ingredients='$newIngredients', Fat='$newFat', Calories='$newCalories', Carbs='$newCarbs', Protein='$newProtein'
                        WHERE nutr_facts_id='$id'");

    // stocks update
    $newQuantity = $_POST["newQuantity"];
    mysqli_query($conn, "UPDATE stocks set `quantity`='$newQuantity'
                        WHERE stocks_id='$stocksID'");

    // mains update
    $newName = $_POST["newName"];
    $newPrice = $_POST["newPrice"];
    mysqli_query($conn, "UPDATE mains set `name`='$newName', `price`='$newPrice'
                        WHERE mains_id='$mainID'");

    var_dump($mainID, $stocksID, $id);
    echo "Record has been updated!";
}
?>


    <hr>
    
    <div class="select-box">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Select ID: 
    <select name="mains_id">
        <?php
        $idQuery = mysqli_query($conn, "SELECT * FROM mains");

        // Loop through the results and populate dropdown options
        while ($row = mysqli_fetch_assoc($idQuery)) {
            echo "<option value='" . $row['mains_id'] . "'>" . $row['name'] . " (" . $row['mains_id'] . ")</option>";
        }
        ?>
    </select>
    <br /><br />
    <a class="back-button" href="mains-table.php">Back</a>
    <input type="submit" name="enter" value="Enter" /><br /><br />
    </form>
    
</body>
</html>