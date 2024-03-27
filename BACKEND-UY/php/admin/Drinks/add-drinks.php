<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/ITPROG-MP/BACKEND-UY/css/admin.css" />
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Drinks</title>
</head>
<body>
    <div class="main-container">
        <div class="header">
            <img src="/ITPROG-MP/BACKEND-UY/images/logo-only.png" alt="Logo">
            ADD NEW DRINKS
        </div>
        <div class="content-box">
            <div class="instructions"> Please fill up the form:</div>
            <form action='<?php echo $_SERVER["PHP_SELF"];?>' method='post'>
                <table>
                <tr><td>Name : </td><td> <input type='text' name='name' size='10'></td></tr>
                    <tr><td>Price : </td><td> <input type='number' name='price' size='10' step=0.01></td></tr>
                    <tr><td><strong>Nutrition facts</strong></td></tr>
                    <tr><td>Description : </td><td> <input type='text' name='desc' size='10'></td></tr>
                    <tr><td>Ingredients :</td> <td> <input type='text' name='Ingredients' size='10'></td></tr>
                    <tr><td>Fat :</td> <td> <input type='text' name='Fat' size='10'></td></tr>
                    <tr><td>Calories :</td> <td> <input type='text' name='Calories' size='10'></td></tr>
                    <tr><td>Carbs :</td> <td> <input type='text' name='Carbs' size='10'></td></tr>
                    <tr><td>Protein :</td> <td> <input type='text' name='Protein' size='10'></td></tr>
                    <br><tr><td><strong>Stocks</strong></td><td></tr>
                    <tr><td>Quantity :</td> <td> <input type='number' name='quantity' size='10'></td></tr>
                    <tr><td colspan="2" class="submit-button"><input type='submit' value='Save' name='save' /></td></tr>
                </table>
            </form>
        </div>
    </div>
    
    <?php
        ob_start(); // Start buffering output
    ?>

    <!-- Modal for Add Data Success -->
    <div class="modal fade <?php if(isset($_POST['save'])) {echo 'show d-block';} ?>" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="background: rgba(0, 0, 0, 0.5);">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Success!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Record has been successfully inserted!
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    
    <script>
        // Script to manually close the modal
        $(document).ready(function() {
            $(".close, .btn-secondary").click(function() {
                $("#exampleModalCenter").removeClass("show d-block").hide();
            });
            
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
            $idQuery = mysqli_query($conn, "SELECT MAX(stocks_id) FROM drinks");
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

            // Create add feature in drinks
            $idQuery = mysqli_query($conn, "SELECT MAX(drinks_id) FROM drinks");
            $idResult = mysqli_fetch_assoc($idQuery);
            $drinks_id = $idResult["MAX(drinks_id)"];
            $drinks_id++;

            echo `Added drinks`;
            var_dump($drinks_id);
            echo `<br>`;

            $insert = "INSERT INTO item VALUES ('$drinks_id')";
            mysqli_query($conn, $insert);

            $name = $_POST["name"];
            $price = (double) $_POST["price"];

            error_reporting(E_ERROR | E_PARSE);

            $insert = "INSERT INTO drinks VALUES ('$drinks_id', '$name', '$price', '$nutr_facts_id', '$stocks_id')";
            mysqli_query($conn, $insert);

            echo "Record has been successfully inserted!";
        }
    ?>

    <?php
        ob_end_flush(); // Send output and turn off buffering
    ?>

    <a href="drinks-table.php">Back</a>
</body>
</html>
