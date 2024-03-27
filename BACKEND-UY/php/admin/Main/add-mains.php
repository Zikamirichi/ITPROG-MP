<?php
session_start(); // Start the session at the very beginning

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save"])) {
    // Database connection and form processing logic here
    $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn));
    mysqli_select_db($conn, "mydb");

    // Assuming all your database logic here is correct and you've successfully inserted the record
    // Just for the sake of demonstrating, let's assume everything went fine
    $_SESSION['success'] = "Record has been successfully inserted!";
    
    // Redirect to the same page to clear POST data
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

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

    <title>Mains</title>
</head>
<body>
    <hr>
    <h2> Add Mains </h2>

    <form action='<?php echo $_SERVER["PHP_SELF"];?>' method='post'>
      <table border='1' width='40%'>
          <tr>
              <td>Name : </td><td> <input type='text' name='name' size='10'></td>
          </tr>
          <tr>
              <td>Price : </td><td> <input type='number' name='price' size='10' step=0.01></td>
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
          <tr>
              <td colspan='2'><input type='submit' name='save' value='Save' class='btn btn-primary' /></td>
          </tr>
      </table>
    </form>

    <?php
        ob_start(); // Start buffering output
    ?>

    <!-- Modal for Add Data Success, now using session to control display -->
    <?php if(isset($_SESSION['success'])): ?>
    <div class="modal fade show d-block" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="background: rgba(0, 0, 0, 0.5);">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Success!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <?php echo $_SESSION['success']; // Display success message ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <?php 
    unset($_SESSION['success']); // Clear the success message
    endif; 
    ?>

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
            $idQuery = mysqli_query($conn, "SELECT MAX(nutr_facts_id) FROM mains");
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

            // Create add feature in mains
            $idQuery = mysqli_query($conn, "SELECT MAX(mains_id) FROM mains");
            $idResult = mysqli_fetch_assoc($idQuery);
            $sides_id = $idResult["MAX(mains_id)"];
            $sides_id++;

            echo `Added mains`;
            var_dump($mains_id);
            echo `<br>`;

            $insert = "INSERT INTO item VALUES ('$mains_id')";
            mysqli_query($conn, $insert);

            $name = $_POST["name"];
            $price = (double) $_POST["price"];

            error_reporting(E_ERROR | E_PARSE);

            $insert = "INSERT INTO mains VALUES ('$mains_id', '$name', '$price', '$nutr_facts_id', '$stocks_id')";
            mysqli_query($conn, $insert);

            echo "Record has been successfully inserted!";
                
        } else {
            echo "Failed to insert record!!!";
        }
    ?>

    <?php
        ob_end_flush(); // Send output and turn off buffering
    ?>
    
    <!-- Link back -->
    <a href="mains-table.php">Back</a>
</body>
</html>
