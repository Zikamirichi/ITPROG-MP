<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/ITPROG-MP/BACKEND-UY/css/admin.css" />
    <title>Nutrition Facts</title>
    <style>
        input[type="submit"] {
            margin-top: 5%;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="header">
            <img src="/ITPROG-MP/BACKEND-UY/images/logo-only.png" alt="Logo">
            ADD NEW NUTRITION FACTS
        </div>
        <div class="content-box">
        <div class="instructions"> Please fill up the table:</div>
            <form action='<?php echo $_SERVER["PHP_SELF"];?>' method='post'>
                <table>
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
                    <tr><td colspan="2" class="submit-button"><input type='submit' value='Save' name='save' /></td></tr>
            </form>
            </table>
        </div>
    </div>

    <?php

        error_reporting(E_ERROR | E_PARSE);
        //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
        $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");
    
        if (isset($_POST["save"])) {

            // Get maximum nutr_facts_id from database
            $idQuery = mysqli_query($conn, "SELECT MAX(nutr_facts_id) FROM nutr_facts");
            $idResult = mysqli_fetch_assoc($idQuery);
            $nutr_facts_id = $idResult["MAX(nutr_facts_id)"];
            $nutr_facts_id++;

            var_dump($nutr_facts_id);

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