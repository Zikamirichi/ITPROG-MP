<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../../css/admin.css" />
    <title>Side Dish</title>
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
    <!-- Sides table -->
    <div class="main-container">
        <div class="header">
            <img src="../../../images/logo-only.png" alt="Logo">
            EDIT SIDE DISH
        </div>

        <?php
                error_reporting(E_ERROR | E_PARSE);
                //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
                $conn = mysqli_connect("localhost", "root", "", "mydb") or die ("Unable to connect!". mysqli_error($conn) );
                mysqli_select_db($conn, "mydb");
        ?>

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
                $factsQuery = mysqli_query($conn, "SELECT si.*, s.quantity 
                FROM sides si JOIN stocks s
                             ON   si.stocks_id = s.stocks_id
                 ORDER BY sides_id;");
                while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
                    echo "<tr>";
                    echo "<td>", $factsResult ["sides_id"], "</td>";
                    echo "<td>", $factsResult ["name"], "</td>";
                    echo "<td>", $factsResult ["price"], "</td>";
                    echo "<td>", $factsResult ["nutr_facts_id"], "</td>";
                    echo "<td>", $factsResult ["quantity"], "</td>";
                    echo "</tr>";
                }
            ?>
            </table>
    
    <?php
        $conn = mysqli_connect("localhost", "root", "", "mydb") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");

        if(isset($_POST["enter"])){
            // nutr enter
            $mainID = $_POST['sides_id'];
            $sidesQuery = mysqli_query($conn, "SELECT * FROM sides WHERE sides_id='$mainID'");
            $getSidesInfo = mysqli_fetch_array($sidesQuery);

            $stocksID = $getSidesInfo['stocks_id'];
            $stocksQuery = mysqli_query($conn, "SELECT * FROM stocks WHERE stocks_id='$stocksID'");
            $getStocks = mysqli_fetch_array($stocksQuery);

            $id = $getSidesInfo['nutr_facts_id'];
            $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id='$id'");
            $getFacts = mysqli_fetch_array($factsQuery);
            
            echo "<form id='saveForm' method='post' action='".$_SERVER['PHP_SELF']."' enctype='multipart/form-data'>";
            // sides info
            echo "<h3>Sides info</h3>";
            echo "<input type='hidden' name='newMainID' value='".$getSidesInfo["sides_id"]."'>".$getSidesInfo["sides_id"]."<br />";
            echo "Name: <input type='text' name='newName' value='".$getSidesInfo["name"]."' size='150'> <br />";
            echo "Price: <input type='number' name='newPrice' value='".$getSidesInfo["price"]."' size='150' step=0.01> <br />";

            // Nutrition facts
            echo "<h3>Nutrition facts</h3>";
            echo "<input type='hidden' name='newID' value='".$getFacts["nutr_facts_id"]."'>".$getFacts["nutr_facts_id"]."<br />";
            echo "Description: <input type='text' name='newDesc' value='".$getFacts["desc"]."' size='10' placeholder='Maximum of 44 characters' maxlength='44'> <br />";
            echo "Ingredients: <input type='text' name='newIngredients' value='".$getFacts["Ingredients"]."' size='10' placeholder='Maximum of 500 characters' maxlength='500'> <br />";
            echo "Fat (g) : <input type='number' name='newFat' value='".$getFacts["Fat"]."' min='0' step='0.1'><br />";
            echo "Calories (g) : <input type='number' name='newCalories' value='".$getFacts["Calories"]."' min='0' step='0.1'><br />";
            echo "Carbs (g) : <input type='number' name='newCarbs' value='".$getFacts["Carbs"]."' min='0' step='0.1'><br />";
            echo "Protein (g) : <input type='number' name='newProtein' value='".$getFacts["Protein"]."' min='0' step='0.1'><br />";

            // quantity info
            echo "<h3>Stocks info</h3>";
            echo "<input type='hidden' name='stocksID' value='".$getStocks["stocks_id"]."'>".$getStocks["stocks_id"]."<br />";
            echo "Quantity: <input type='number' name='newQuantity' value='".$getStocks["quantity"]."' size='150'> <br />";

            // Image
            echo "<h3>Image</h3>";
            echo '<img src="' . '../../../images/' . $getSidesInfo['image_name'] . '" width="50">';
            echo "<br><br>";
            echo '<input type="file" name="newImage">';

        echo "<div class='save-box'>";
        echo "<button type='button' id='saveButton' class='submit-bttn'>Save</button><br />";
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

            // stocks update
            $newQuantity = $_POST["newQuantity"];

            // sides update
            $newName = $_POST["newName"];
            $newPrice = $_POST["newPrice"];
            
            // Handle image upload
            if ($_FILES['newImage']['name']) {
                $target_dir = __DIR__ . "/../../../images/";
                $image = $_FILES['newImage']['name'];
                $imageExt = pathinfo($image, PATHINFO_EXTENSION);

                // Allow only .jpg files
                if ($imageExt == "jpg") {
                    
                    $target_file = $target_dir . basename($image);
                    move_uploaded_file($_FILES["newImage"]["tmp_name"], $target_file);

                    // UPDATE STATEMENTS AFTER SUCCESSFUL IMAGE UPLOAD
                    mysqli_query($conn, "UPDATE nutr_facts set `desc`='$newDesc', Ingredients='$newIngredients', Fat='$newFat', Calories='$newCalories', Carbs='$newCarbs', Protein='$newProtein'
                    WHERE nutr_facts_id='$id'");
                                
                    mysqli_query($conn, "UPDATE stocks set `quantity`='$newQuantity'
                    WHERE stocks_id='$stocksID'");
                    
                    // Update database with new image name
                    mysqli_query($conn, "UPDATE sides set `name`='$newName', `price`='$newPrice', `image_name`='$image'
                                        WHERE sides_id='$mainID'");
                } 
                
                else {
                    
                    echo "Only .jpg files allowed, please try again.";
                }
            } 
            
            else {
                
                echo "Error uploading image";
            }

            echo "Record has been updated!";
        }
    ?>

    <hr>

    <div class="select-box">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    Select ID: 
    <select name="sides_id">
        <?php
        $idQuery = mysqli_query($conn, "SELECT * FROM sides");

        // Loop through the results and populate dropdown options
        while ($row = mysqli_fetch_assoc($idQuery)) {
            echo "<option value='" . $row['sides_id'] . "'>" . $row['name'] . " (" . $row['sides_id'] . ")</option>";
        }
        ?>
    </select>
    <br/><br/>
    <a class="back-button" href="sides-table.php">Back</a>
    <input type="submit" name="enter" value="Enter" /><br /><br />
    </form>
    </div>
    
    <!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to save the changes?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Back</button>
                <button type="button" id="confirmSaveButton" class="submit-bttn">Save Changes</button>
            </div>
        </div>
    </div>
</div>
<!-- New Modal for Success Alert -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Save successful!
            </div>
            <div class="modal-footer">
                <button type="button" id="successModalButton" class="submit-bttn" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Updated Script -->
<script>
    $(document).ready(function() {
        // Show confirmation modal when the Save button is clicked
        $("#saveButton").click(function() {
            // Show the modal
            $('#confirmationModal').modal('show');
        });

        // Handle Save button click inside the modal
        $("#confirmSaveButton").click(function() {
            // Show success modal after form submission
            $('#confirmationModal').modal('hide');
            $('#successModal').modal('show');
        });

        $("#successModalButton").click(function() {
            // Submit the form with the name "save"
            $("#saveForm").append("<input type='hidden' name='save' value='save'>").submit();
        });
    });
</script>
</body>
</html>