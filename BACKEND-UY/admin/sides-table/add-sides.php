<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <hr>
    <h2> Add Sides </h2>
        
    <form action='<?php echo $_SERVER["PHP_SELF"];?>' method='post'>
    <table border='1' width='40%'>
        <tr>
            <td>Name : </td><td> <input type='text' name='name' size='10'></td>
        </tr>
        <tr>
            <td>Price : </td><td> <input type='number' name='price' size='10'></td>
        </tr>
        <tr>
            <td><strong>Nutrition facts</strong></td><td>
        </tr>
        <tr>
            <td>Description : </td><td> <input type='text' name='desc' size='10'></td>
        </tr>
        <tr>
            <td>Ingredients :</td> <td> <input type='text' name='Ingredients' size='10'></td>
        </tr>
        <tr>
            <td>Fat :</td> <td> <input type='text' name='Fat' size='10'></td>
        </tr>
        <tr>
            <td>Calories :</td> <td> <input type='text' name='Calories' size='10'></td>
        </tr>
        <tr>
            <td>Carbs :</td> <td> <input type='text' name='Carbs' size='10'></td>
        </tr>
        <tr>
            <td>Protein :</td> <td> <input type='text' name='Protein' size='10'></td>
        </tr>
        <tr>
            <td><strong>Stocks</strong></td><td>
        </tr>
        <tr>
            <td>Quantity :</td> <td> <input type='number' name='quantity' size='10'></td>
        </tr>
        <tr><td colspan='2'><input type='submit' value='Save' name='save' /></td></tr>
    </table>

    <?php

        error_reporting(E_ERROR | E_PARSE);
        //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
        $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");
    
        if (isset($_POST["save"])) {
            // Get maximum nutr_facts_id from database
            $idQuery = mysqli_query($conn, "SELECT MAX(nutr_facts_id) FROM sides");
            $idResult = mysqli_fetch_assoc($idQuery);
            $nutr_facts_id = $idResult["MAX(nutr_facts_id)"];
            $nutr_facts_id++;

            echo `Added nutrition facts`;
            var_dump($nutr_facts_id);
            echo `<br>`;

            $desc = $_POST["desc"];
            $ingredients = $_POST["Ingredients"];
            $fat = $_POST["Fat"];
            $calories = $_POST["Calories"];
            $protein = $_POST["Carbs"];
            $carbs = $_POST["Protein"];

            error_reporting(E_ERROR | E_PARSE);
            
            $insert = "INSERT INTO nutr_facts VALUES ('$nutr_facts_id', '$desc', '$ingredients', '$fat', '$calories', '$protein', '$carbs')";
            mysqli_query($conn, $insert);

            // create stocks
            $idQuery = mysqli_query($conn, "SELECT MAX(stocks_id) FROM sides");
            $idResult = mysqli_fetch_assoc($idQuery);
            $stocks_id = $idResult["MAX(stocks_id)"];
            $stocks_id++;

            echo `Added stocks`;
            var_dump($stocks_id);
            echo `<br>`;

            $quantity = (int) $_POST["quantity"];

            error_reporting(E_ERROR | E_PARSE);
            
            $insert = "INSERT INTO stocks VALUES ('$stocks_id', '$quantity')";
            mysqli_query($conn, $insert);

            // Create add feature in sides
            $idQuery = mysqli_query($conn, "SELECT MAX(sides_id) FROM sides");
            $idResult = mysqli_fetch_assoc($idQuery);
            $sides_id = $idResult["MAX(sides_id)"];
            $sides_id++;

            echo `Added sides`;
            var_dump($sides_id);
            echo `<br>`;

            $insert = "INSERT INTO item VALUES ('$sides_id')";
            mysqli_query($conn, $insert);

            $name = $_POST["name"];
            $price = (double) $_POST["price"];

            error_reporting(E_ERROR | E_PARSE);

            $insert = "INSERT INTO sides VALUES ('$sides_id', '$name', '$price', '$nutr_facts_id', '$stocks_id')";
            mysqli_query($conn, $insert);

            echo "Record has been successfully inserted!";
                
        } else {
            echo "Failed to insert record!!!";
        }
    ?>

    <a href="sides-table.php">Back</a>
</body>
</html>