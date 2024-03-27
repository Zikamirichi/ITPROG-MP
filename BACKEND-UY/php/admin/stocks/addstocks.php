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
    <title>Document</title>
</head>
<body>
    <hr>
    <h2>Add New Stocks</h2>
        
    <form action='<?php echo $_SERVER["PHP_SELF"];?>' method='post'>
    <table border='1' width='40%'>
        <tr>
            <td>Type :</td>
            <td>
                <select name="type">
                    <option value="main">Main</option>
                    <option value="sides">Sides</option>
                    <option value="drinks">Dishes</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Quantity :</td>
            <td><input type='number' name='quantity' size='10'></td>
        </tr>
        <tr><<td colspan="2" class="submit-button"><input type='submit' value='Save' name='save' /></td></tr>
    </table>

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
        $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn));
        mysqli_select_db($conn, "mydb");

        if (isset($_POST["save"])) {
            $quantity = $_POST["quantity"];
            $type = $_POST["type"]; // Retrieve the selected type
            $prefix = ($type == 'main') ? 'm' : (($type == 'sides') ? 's' : 'd');
        
            // Query to find the last ID for the selected type
            $query = "SELECT stocks_id FROM stocks WHERE stocks_id LIKE '$prefix%' ORDER BY stocks_id DESC LIMIT 1";
            $result = mysqli_query($conn, $query);
            
            if ($result && mysqli_num_rows($result) > 0) {
                $lastRow = mysqli_fetch_assoc($result);
                $lastId = $lastRow['stocks_id'];
                $numericPart = substr($lastId, 1); // Remove the prefix
                $newIdNumber = intval($numericPart) + 1;
            } else {
                // If there are no records for the selected type, start numbering from 101
                $newIdNumber = 101;
            }
        
            $newStocksId = $prefix . str_pad($newIdNumber, 2, "0", STR_PAD_LEFT); // Ensures the ID has at least 2 digits
        
            error_reporting(E_ERROR | E_PARSE);
            
            $insert = "INSERT INTO stocks (stocks_id, quantity) VALUES ('$newStocksId', '$quantity')";
            if(mysqli_query($conn, $insert)){
                echo "Record has been successfully inserted with ID $newStocksId!";
            } else {
                echo "Failed to insert record: " . mysqli_error($conn);
            }        
        } else {
            echo "Please fill out the form to insert a record.";
        }
    ?>

    <?php
        ob_end_flush(); // Send output and turn off buffering
    ?>
    <a href="modstocks.php">Back</a>
</body>
</html>