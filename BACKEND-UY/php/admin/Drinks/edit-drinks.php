<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/ITPROG-MP/BACKEND-UY/css/admin.css" />
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>Drinks</title>
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
            <img src="/ITPROG-MP/BACKEND-UY/images/logo-only.png" alt="Logo">
            EDIT DRINKS
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
                $factsQuery = mysqli_query($conn, "SELECT * FROM drinks ORDER BY drinks_id");
                while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
                    echo "<tr>";
                    echo "<td>", $factsResult ["drinks_id"], "</td>";
                    echo "<td>", $factsResult ["names"], "</td>";
                    echo "<td>", $factsResult ["price"], "</td>";
                    echo "<td>", $factsResult ["nutr_facts_id"], "</td>";
                    echo "<td>", $factsResult ["stocks_id"], "</td>";
                    echo "</tr>";
                }
            ?>
            </table>

            <?php
            if(isset($_POST["enter"])){
                $mainID = $_POST['drinks_id'];
                $drinksQuery = mysqli_query($conn, "SELECT * FROM drinks WHERE drinks_id='$mainID'");
                $getDrinksInfo = mysqli_fetch_array($drinksQuery);

                $stocksID = $getDrinksInfo['stocks_id'];
                $stocksQuery = mysqli_query($conn, "SELECT * FROM stocks WHERE stocks_id='$stocksID'");
                $getStocks = mysqli_fetch_array($stocksQuery);

                $id = $getDrinksInfo['nutr_facts_id'];
                $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id='$id'");
                $getFacts = mysqli_fetch_array($factsQuery);
                ?>

                <form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                    <!-- Hidden fields to submit necessary data -->
                    <input type='hidden' name='newID' value='<?php echo $id; ?>'>
                    <input type='hidden' name='stocksID' value='<?php echo $stocksID; ?>'>
                    <input type='hidden' name='newMainID' value='<?php echo $mainID; ?>'>

                    <h3>Drinks info</h3>
                    Name: <input type='text' name='newName' value='<?php echo $getDrinksInfo["names"]; ?>' size='150'><br />
                    Price: <input type='number' name='newPrice' value='<?php echo $getDrinksInfo["price"]; ?>' size='150' step=0.01><br />

                    <h3>Nutrition facts</h3>
                    Description: <input type='text' name='newDesc' value='<?php echo $getFacts["desc"]; ?>' size='150'><br />
                    Ingredients: <input type='text' name='newIngredients' value='<?php echo $getFacts["Ingredients"]; ?>' size='100'><br />
                    Fat: <input type='text' name='newFat' value='<?php echo $getFacts["Fat"]; ?>'><br />
                    Calories: <input type='text' name='newCalories' value='<?php echo $getFacts["Calories"]; ?>'><br />
                    Carbs: <input type='text' name='newCarbs' value='<?php echo $getFacts["Carbs"]; ?>'><br />
                    Protein: <input type='text' name='newProtein' value='<?php echo $getFacts["Protein"]; ?>'><br />

                    <h3>Stocks info</h3>
                    Quantity: <input type='number' name='newQuantity' value='<?php echo $getStocks["quantity"]; ?>' size='150'><br />

                    <div class=save-box>
                        <input type='submit' name='save' value='Save'><br />
                    </div>
                </form>

            <?php } ?>

            <?php
            if(isset($_POST["save"])){
                $newID = $_POST["newID"];
                $newDesc = $_POST["newDesc"];
                $newIngredients = $_POST["newIngredients"];
                $newFat = $_POST["newFat"];
                $newCalories = $_POST["newCalories"];
                $newCarbs = $_POST["newCarbs"];
                $newProtein = $_POST["newProtein"];
                mysqli_query($conn, "UPDATE nutr_facts SET `desc`='$newDesc', Ingredients='$newIngredients', Fat='$newFat', Calories='$newCalories', Carbs='$newCarbs', Protein='$newProtein' WHERE nutr_facts_id='$newID'");

                $stocksID = $_POST["stocksID"];
                $newQuantity = $_POST["newQuantity"];
                mysqli_query($conn, "UPDATE stocks SET `quantity`='$newQuantity' WHERE stocks_id='$stocksID'");

                $newMainID = $_POST["newMainID"];
                $newName = $_POST["newName"];
                $newPrice = $_POST["newPrice"];
                mysqli_query($conn, "UPDATE drinks SET `names`='$newName', `price`='$newPrice' WHERE drinks_id='$newMainID'");

                // Show success message modal
                echo "<script>$(document).ready(function(){ $('#successMessageModal').modal('show'); });</script>";
            }
            ?>

        </div>
    </div>
    
    <hr>

    <div class="select-box">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            Select ID: 
            <select name="drinks_id">
                <?php
                $idQuery = mysqli_query($conn, "SELECT * FROM drinks");
                while ($row = mysqli_fetch_assoc($idQuery)) {
                    echo "<option value='" . $row['drinks_id'] . "'>" . $row['names'] . " (" . $row['drinks_id'] . ")</option>";
                }
                ?>
            </select>
            <br /><br />
            <a class="back-button" href="drinks-table.php">Back</a>
            <input type="submit" name="enter" value="Enter"><br /><br />
        </form>
    </div>

    <!-- Success Message Modal -->
    <div class="modal fade" id="successMessageModal" tabindex="-1" role="dialog" aria-labelledby="successMessageModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successMessageModalTitle">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Record has been updated!
                </div>
                <div class="modal-footer">
                    <button type="button" class="back-button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to show the modal when record is updated -->
    <script>
        <?php if(isset($_POST["save"])) { ?>
            $(document).ready(function(){
                $('#successMessageModal').modal('show');
            });
        <?php } ?>


        // Prompt user with confirmation message if there are unsaved changes
        var formChanged = false; // Flag to track form changes

        // Listen for changes in form fields
        $('input, select').on('change', function() {
            formChanged = true;
        });

        // Function to show confirmation message
        function showConfirmation(event) {
            if (formChanged) {
                var confirmationMessage = 'Any unsaved progress will be lost. Are you sure you want to leave this page?';
                (event || window.event).returnValue = confirmationMessage;
                return confirmationMessage;
            }
        }

        // Triggered when form is submitted
        $('form').submit(function() {
            formChanged = false; // Reset formChanged flag
        });

        // Show confirmation when user tries to reload or navigate away
        window.onbeforeunload = showConfirmation;
    </script>
</body>
</html>