<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/admin.css" />
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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


        .prompt-card {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            padding: 20px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            z-index: 9999;
            display: none;
        }

        .prompt-card p {
            margin-bottom: 20px;
        }

        .button-container {
            display: flex;
            justify-content: space-around;
        }

        .exit-button, .cancel-button {
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .exit-button {
            background-color: #D4471F;
            color: white;
            border: none;
        }

        .exit-button:hover {
            background-color: #B3370A;
        }

        .cancel-button {
            background-color: #CED3D7;
            color: #333;
            border: none;
        }

        .cancel-button:hover {
            background-color: #B8BFC4;
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
                    <tr><td>Description : </td><td> <input type='text' name='desc' size='10' required placeholder="Maximum of 44 characters" maxlength="44"></td></tr>
                    <tr><td>Ingredients :</td> <td> <input type='text' name='Ingredients' size='10' required placeholder="Maximum of 500 characters" maxlength="44"></td></tr>
                    <tr><td>Fat (g) :</td> <td> <input type='number' name='Fat' size='10' required min="0" step="0.1"></td></tr>
                    <tr><td>Calories (g) :</td> <td> <input type='number' name='Calories' size='10' required min="0" step="0.1"></td></tr>
                    <tr><td>Carbs (g) :</td> <td> <input type='number' name='Carbs' size='10' required min="0" step="0.1"></td></tr>
                    <tr><td>Protein (g) :</td> <td> <input type='number' name='Protein' size='10' required min="0" step="0.1"></td></tr>
                    
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <br><tr><td><strong>Stocks</strong></td><td></tr>
                    <tr><td>Quantity :</td> <td> <input type='number' name='quantity' size='10' required></td></tr>
                    <tr><td>Upload Image :</td> <td> <input type='file' name='image' size='10' required></td></tr>
                    <tr>
                    <td colspan="2" class="submit-button">
                        <a href="drinks-table.php" class="back-button">Back</a>
                        <input type='submit' value='Save' name='save'>
                    </td>
                </tr>
            </form>
        </table>
        </div>
    </div>

    <?php
        ob_start(); // Start buffering output
    ?>


    <!-- Unsaved changes prompt card -->
    <div class="prompt-card" id="unsaved-prompt">
        <p>Any unsaved changes will be lost.</p>
        <div class="button-container">
            <button class="back-button" id="cancel-btn">Cancel</button>
            <button class="btn btn-danger" id="exit-btn">Exit</button>
        </div>
    </div>

    <script>
    var originalFormValues = {};

    function resetFormEdited() {
        for (var key in originalFormValues) {
            if (originalFormValues.hasOwnProperty(key)) {
                document.getElementById(key).value = originalFormValues[key];
            }
        }
    }

    function hasNonEmptyInputs() {
        var formInputs = document.querySelectorAll('input[type="text"], input[type="number"]');
        for (var i = 0; i < formInputs.length; i++) {
            if (formInputs[i].value.trim() !== '') {
                return true;
            }
        }
        return false;
    }

    document.getElementById('cancel-btn').addEventListener('click', function() {
        document.getElementById('unsaved-prompt').style.display = 'none';
        resetFormEdited();
    });

    document.getElementById('exit-btn').addEventListener('click', function() {
            window.location.href = 'drinks-table.php';
    });

    document.querySelector('.back-button').addEventListener('click', function(event) {
        if (hasNonEmptyInputs()) {
            document.getElementById('unsaved-prompt').style.display = 'block';
            event.preventDefault();
        }
    });

    document.getElementById('add-drinks-form').addEventListener('submit', function() {
        resetFormEdited();
    });
    </script>


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

           /* echo `Added nutrition facts`;
            var_dump($nutr_facts_id);
            echo `<br>`;*/

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

           /*echo `Added stocks`;
            var_dump($stocks_id);
            echo `<br>`;*/

            $quantity = (int) $_POST["quantity"];

            // Create add feature in drinks
            $idQuery = mysqli_query($conn, "SELECT MAX(drinks_id) FROM drinks");
            $idResult = mysqli_fetch_assoc($idQuery);
            $drinks_id = $idResult["MAX(drinks_id)"];
            $drinks_id++;

           /*echo `Added drinks`;
            var_dump($drinks_id);
            echo `<br>`;*/

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

    <?php
        ob_end_flush(); // Send output and turn off buffering
    ?>

</body>
</html>