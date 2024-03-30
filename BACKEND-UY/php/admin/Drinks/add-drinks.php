<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/admin.css" />
    <title>Drinks</title>
    <style>
        input[type="submit"] {
            margin-top: 5%;
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

        .button-table:active {
            background-color: #D4471F;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="header">
            <img src="../../../images/logo-only.png" alt="Logo">
            ADD NEW DRINKS
        </div>
        <div class="content-box">
            <div class="instructions"> Please fill up the form:</div>
            <form action='<?php echo $_SERVER["PHP_SELF"];?>' method='post' enctype='multipart/form-data'>
                <table>
                    <tr><td>Name : </td><td> <input type='text' name='name' size='10' required></td></tr>
                    <tr><td>Price : </td><td> <input type='number' name='price' size='10' step=0.01 required></td></tr>
                    
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr><td><strong>Nutrition facts</strong></td></tr>
                    <tr><td>Description : </td><td> <input type='text' name='desc' size='10' required></td></tr>
                    <tr><td>Ingredients :</td> <td> <input type='text' name='Ingredients' size='10' required></td></tr>
                    <tr><td>Fat :</td> <td> <input type='number' name='Fat' size='10' required></td></tr>
                    <tr><td>Calories :</td> <td> <input type='number' name='Calories' size='10' required></td></tr>
                    <tr><td>Carbs :</td> <td> <input type='number' name='Carbs' size='10' required></td></tr>
                    <tr><td>Protein :</td> <td> <input type='number' name='Protein' size='10' required></td></tr>
                    
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <br><tr><td><strong>Stocks</strong></td><td></tr>
                    <tr><td>Quantity :</td> <td> <input type='number' name='quantity' size='10' required></td></tr>
                    <tr><td>Upload Image :</td> <td> <input type='file' name='image' size='10' required></td></tr>
                    <tr>
                    <td colspan="2" class="submit-button">
                        <a href="drinks-table.php" class="back-button">Back</a>
                        <input type="submit" value="Save" name='save' />
                    </td>
                </tr>
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
            $idQuery = mysqli_query($conn, "SELECT MAX(nutr_facts_id) FROM drinks");
            $idResult = mysqli_fetch_assoc($idQuery);
            $nutr_facts_id = $idResult["MAX(nutr_facts_id)"];
            $nutr_facts_id++;

            echo `Added nutrition facts`;
            echo `<br>`;

            $desc = $_POST["desc"];
            $ingredients = $_POST["Ingredients"];
            $fat = $_POST["Fat"];
            $calories = $_POST["Calories"];
            $protein = $_POST["Carbs"];
            $carbs = $_POST["Protein"];

            // create stocks
            $idQuery = mysqli_query($conn, "SELECT MAX(stocks_id) FROM drinks");
            $idResult = mysqli_fetch_assoc($idQuery);
            $stocks_id = $idResult["MAX(stocks_id)"];
            $stocks_id++;

            echo `Added stocks`;
            echo `<br>`;

            $quantity = (int) $_POST["quantity"];

            // Create add feature in drinks
            $idQuery = mysqli_query($conn, "SELECT MAX(drinks_id) FROM drinks");
            $idResult = mysqli_fetch_assoc($idQuery);
            $drinks_id = $idResult["MAX(drinks_id)"];
            $drinks_id++;

            echo `Added drinks`;
            echo `<br>`;

            $name = $_POST["name"];
            $price = (double) $_POST["price"];

            // Check for image upload 
            // Reference: https://www.w3schools.com/php/php_file_upload.asp
            if($_FILES['image']['name']) {

                $target_dir = __DIR__ . "/../../../images/";
                
                $image = $_FILES['image']['name'];
                
                // Get image extension
                $imageExt = pathinfo($image, PATHINFO_EXTENSION);
                
                // Allow only .jpg files
                if($imageExt == "jpg") {
                
                    $target_file = $target_dir . basename($image);
                    
                    // Move uploaded file
                    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

                    // Insert into database
                    error_reporting(E_ERROR | E_PARSE);
                    $insert = "INSERT INTO nutr_facts VALUES ('$nutr_facts_id', '$desc', '$ingredients', '$fat', '$calories', '$protein', '$carbs')";
                    mysqli_query($conn, $insert);

                    error_reporting(E_ERROR | E_PARSE);
                    $insert = "INSERT INTO stocks VALUES ('$stocks_id', '$quantity')";
                    mysqli_query($conn, $insert);

                    $insert = "INSERT INTO item VALUES ('$drinks_id')";
                    mysqli_query($conn, $insert);
                
                    error_reporting(E_ERROR | E_PARSE);
                    $insert = "INSERT INTO drinks VALUES ('$drinks_id', '$name', '$price', '$nutr_facts_id', '$stocks_id', '$image')";
                    mysqli_query($conn, $insert);

                    echo "Record has been successfully inserted!";
                } 
                
                else {
                    
                    echo "Only .jpg files allowed, please try again.";
                }
            } 
              
              else {
                
                echo "Error uploading image";
              }
        } 
    ?>

</body>
</html>