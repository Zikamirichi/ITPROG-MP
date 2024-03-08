<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <hr>
    <h2> Add New Nutrition Facts </h2>
        
    <form action='<?php echo $_SERVER["PHP_SELF"];?>' method='post'>
    <table border='1' width='40%'>
        <tr>
            <td>Nutrition Facts ID : </td> <td> <input type='text' name='nutr_facts_id' size='10'></td>
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
        <tr><td colspan='2'><input type='submit' value='Save' name='save' /></td></tr>
    </table>

    <?php

        error_reporting(E_ERROR | E_PARSE);
        //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
        $conn = mysqli_connect("localhost", "root", "12345", "mydb", "3360") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");
    
        if(isset($_POST["save"])){
        $nutr_facts_id = $_POST["nutr_facts_id"];
        $desc = $_POST["desc"];
        $ingredients = $_POST["Ingredients"];
        $fat = $_POST["Fat"];
        $calories = $_POST["Calories"];
        $protein = $_POST["Carbs"];
        $carbs = $_POST["Protein"];

        error_reporting(E_ERROR | E_PARSE);
        
        $insert = "INSERT INTO nutr_facts VALUES ('$nutr_facts_id', '$desc', '$ingredients', '$fat', '$calories', '$protein', '$carbs')";
        mysqli_query($conn, $insert);
        echo "Record has been successfully inserted!";
        
        } else {
            echo "Failed to insert record!!!";
        }
    ?>

    <a href="modnutrfacts.php">Back</a>
</body>
</html>