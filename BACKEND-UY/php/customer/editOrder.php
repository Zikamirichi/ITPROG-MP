<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Reference: https://www.w3schools.com/php/php_looping_foreach.asp 
                    https://stackoverflow.com/questions/21349194/store-array-of-objects-in-php-session 
                    https://www.plus2net.com/php_tutorial/array-session.php 
                    https://www.w3schools.com/php/func_math_min.asp 
                    https://stackoverflow.com/questions/35618366/continuously-updating-php-page -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/navbar.css" />
    <link rel="stylesheet" type="text/css" href="../../css/dish.css" />
    <link rel="stylesheet" type="text/css" href="../../css/cart.css" />

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php
        //header("refresh: 5; URL=processOrders.php"); //Refresh page every 5 seconds to reflect combo changes
    ?> 
    
  </head>
    <title>Cart</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('../../images/menubg.png'); 
            background-size: cover;
            background-position: center;
            display: flex;
        }

        hr {
            border-color: black;
            width: 95%;
        }

        .input-quantity {
            text-align: center;
            width: 60%;
            border: #CED3D7 1px solid;
            
        }

        .x-button {
            background-color: #ff0000; 
            color: #fff; 
            border: none; 
            border-radius: 50%; 
            width: 20px; 
            height: 20px; 
            font-size: 14px; 
            cursor: pointer; 
        }
    </style>
</head>
<body>
    <?php
        $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");

        session_start();
        ob_start(); // start buffering output
    ?>
    <div class="navigation-bar">
        <ul>
            <li><li><a href="#" data-toggle="modal" data-target="#cancelConfirmationModal">
                    <div class="navbar-icon">
                        <img src="../../images/white-home-button.png" alt="Homepage">
                    </div>
                </a></li>
            <li><a href="mains.php">
                <div class="navbar-icon">
                    <img src="../../images/white-main-button.png" alt="Main Dishes">
                </div>
            </a></li>

            <li><a href="sides.php">
                <div class="navbar-icon">
                    <img src="../../images/white-side-button.png" alt="Side Dishes">
                </div>
            </a></li>
            <li><a href="drinks.php">
                <div class="navbar-icon">
                    <img src="../../images/white-drink-button.png" alt="Drinks">
                </div>
            </a></li>
            <li><a href="cart.php" class="active">
                <div class="navbar-icon">
                    <img src="../../images/white-cart-button.png" alt="Cart">
                </div>
            </a></li>
        </ul>
    </div>

    <div class="right-container">
        <div class="select-text"> EDIT CART</div>
            <div class="cart-main-box">
    
   <?php

    //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
    $cartID = $_SESSION['cartID']; // Get the cart ID of the current user

    displayCombo($conn, $cartID);

    // Places Individual Ala Carte Items in Separate cart-item-boxes
    $displayAlacarteResult = displayAlacarte($conn, $cartID); // Get Ala Carte Items from DB
    while ($alaCarteRow = mysqli_fetch_assoc($displayAlacarteResult)) { // Loop through all resulting rows in ala_carte query

        $orderID = $alaCarteRow['ordr_id'];

        $mainName = $alaCarteRow['mainName'];       // Get Item Info from Queries
        $mainPrice = $alaCarteRow['mainPrice'];     // Name and Price of Ala Carte Items
        $sideName = $alaCarteRow['sideName'];
        $sidePrice = $alaCarteRow['sidePrice'];
        $drinkName = $alaCarteRow['drinkName'];
        $drinkPrice = $alaCarteRow['drinkPrice'];

        if ($mainName != NULL) { // If the order is a main

            $mainQuantity = $alaCarteRow['quantity'];
            $totalMainPrice = $mainPrice * $mainQuantity; // Calculate total price for main
            echo "<div class='cart-item-box'>";
                echo "<div class='ala-carte-item'>";
                    echo "<table>";
                        echo "<tr>";
                            echo "<td style='width: 63%'>$mainName</td>";
                            echo '<form method="post">'; // Form to change quantity of main
                                echo '<td style="width: 9%"><button type="submit" name="confirmMain">Confirm</button></td>';
                                echo "<td style='width: 13%'>x <input type='number' class='input-quantity' name='mainQuan' value='$mainQuantity' min='1'></td>"; 
                                echo '<input type="hidden" name="order_id" value="'.$orderID.'">';
                            echo '</form>';
                            echo "<td>PHP " . number_format($totalMainPrice, 2) ."</td>";
                            echo '<form method="post">';
                                echo "<td><button type='submit' class='x-button' name='deleteAlaMain'>X</button></td>";
                                echo '<input type="hidden" name="order_id" value="'.$orderID.'">';
                                echo '<input type="hidden" name="mainQuan" value="'.$mainQuantity.'">';
                            echo '</form>';
                        echo "</tr>";
                    echo "</table>";
                echo "</div>";
            echo "</div>";
        }

        if ($sideName != NULL) { // If the order is a side   

            $sideQuantity = $alaCarteRow['quantity'];
            $totalSidePrice = $sidePrice * $sideQuantity; // Calculate total price for side
            echo "<div class='cart-item-box'>";
                echo "<div class='ala-carte-item'>";
                    echo "<table>";
                        echo "<tr>";
                            echo "<td style='width: 63%'>$sideName</td>";
                            echo '<form method="post">'; // Form to change quantity of side
                                echo '<td style="width: 9%"><button type="submit" name="confirmSide">Confirm</button></td>';
                                echo "<td style='width: 13%'>x <input type='number' class='input-quantity' name='sideQuan' value='$sideQuantity' min='1'></td>"; 
                                echo '<input type="hidden" name="order_id" value="'.$orderID.'">';
                            echo '</form>';
                            echo "<td >PHP " . number_format($totalSidePrice,2) ."</td>";
                            echo '<form method="post">';
                                echo "<td><button type='submit' class='x-button' name='deleteAlaSide'>X</button></td>";
                                echo '<input type="hidden" name="order_id" value="'.$orderID.'">';
                                echo '<input type="hidden" name="sideQuan" value="'.$sideQuantity.'">';
                            echo '</form>';
                        echo "</tr>";
                    echo "</table>";
                echo "</div>";
            echo "</div>";
        }

        if ($drinkName != NULL) { // If the order is a drink
        
            $drinkQuantity = $alaCarteRow['quantity'];
            $totalDrinkPrice = $drinkPrice * $drinkQuantity; // Calculate total price for drink
            echo "<div class='cart-item-box'>";
                echo "<div class='ala-carte-item'>";
                    echo "<table>";
                        echo "<tr>";
                            echo "<td style='width: 63%'>$drinkName</td>";
                            echo '<form method="post">'; // Form to change quantity of drink
                                echo '<td style="width: 9%"><button type="submit" name="confirmDrink">Confirm</button></td>';
                                echo "<td style='width: 13%'>x <input type='number' class='input-quantity' name='drinkQuan' value='$drinkQuantity' min='1'></td>"; 
                                echo '<input type="hidden" name="order_id" value="'.$orderID.'">';
                            echo '</form>';
                            echo "<td>PHP " . number_format($totalDrinkPrice,2) ."</td>";
                            echo '<form method="post">';
                                echo "<td><button type='submit' class='x-button' name='deleteAlaDrink'>X</button></td>";
                                echo '<input type="hidden" name="order_id" value="'.$orderID.'">';
                                echo '<input type="hidden" name="drinkQuan" value="'.$drinkQuantity.'">';
                            echo '</form>';
                        echo "</tr>";
                    echo "</table>";
                echo "</div>";
            echo "</div>";
        }
    }

    if (isset($_POST['deleteAlaMain'])) {

        $orderID = $_POST['order_id'];
        $mainQuantity = $_POST['mainQuan'];

        $stocksIDQuery = "SELECT stocks_id FROM mains 
        JOIN item ON mains.mains_id = item.item_id
        JOIN order_table ON item.item_id = order_table.item_id WHERE ordr_id = '$orderID'";
        $stocksIDResult = mysqli_query($conn, $stocksIDQuery);
        $stocksIDRow = mysqli_fetch_assoc($stocksIDResult);
        $stocksID = $stocksIDRow['stocks_id'];

        $deleteAlaCarteQuery = "DELETE FROM ala_carte WHERE ordr_id = '$orderID'";
        mysqli_query($conn, $deleteAlaCarteQuery);

        $deleteOrderQuery = "DELETE FROM order_table WHERE ordr_id = '$orderID'";
        mysqli_query($conn, $deleteOrderQuery);

        // INCREMENT STOCKS AFTER DELETE
        $updateStocksQuery = "UPDATE stocks SET quantity = quantity + $mainQuantity WHERE stocks_id = '$stocksID'";
        mysqli_query($conn, $updateStocksQuery);

        header("Refresh:0");
    }

    if (isset($_POST['confirmMain'])) { // If the user wants to change the quantity of a main item

        $orderID = $_POST['order_id'];
        $newQuantity = $_POST['mainQuan'];

        // Retrieve Stocks ID
        $stocksIDQuery = "SELECT stocks_id FROM mains 
        JOIN item ON mains.mains_id = item.item_id
        JOIN order_table ON item.item_id = order_table.item_id WHERE ordr_id = '$orderID'";
        $stocksIDResult = mysqli_query($conn, $stocksIDQuery);
        $stocksIDRow = mysqli_fetch_assoc($stocksIDResult);
        $stocksID = $stocksIDRow['stocks_id'];

        $updateAlaCarteQuery = "UPDATE order_table SET ordr_quan = '$newQuantity' WHERE ordr_id = '$orderID'";
        mysqli_query($conn, $updateAlaCarteQuery);

        if ($newQuantity < $mainQuantity) { // Increment / Decrement Stocks Based on User Action
            
            $incrementQuantity = $mainQuantity - $newQuantity;
            $updateStocksQuery = "UPDATE stocks SET quantity = quantity + $incrementQuantity WHERE stocks_id = '$stocksID'";
            mysqli_query($conn, $updateStocksQuery);
        } 
            
        else if ($newQuantity > $mainQuantity) {
        
            $decrementQuantity = $newQuantity - $mainQuantity;
            $updateStocksQuery = "UPDATE stocks SET quantity = quantity - $decrementQuantity WHERE stocks_id = '$stocksID'";
            mysqli_query($conn, $updateStocksQuery);
        }

        header("Location: {$_SERVER['PHP_SELF']}");
    }

    if (isset($_POST['deleteAlaSide'])) {

        $orderID = $_POST['order_id'];
        $sideQuantity = $_POST['sideQuan'];

        $stocksIDQuery = "SELECT stocks_id FROM sides
        JOIN item ON sides.sides_id = item.item_id
        JOIN order_table ON item.item_id = order_table.item_id WHERE ordr_id = '$orderID'";
        $stocksIDResult = mysqli_query($conn, $stocksIDQuery);
        $stocksIDRow = mysqli_fetch_assoc($stocksIDResult);
        $stocksID = $stocksIDRow['stocks_id'];

        $deleteAlaCarteQuery = "DELETE FROM ala_carte WHERE ordr_id = '$orderID'";
        mysqli_query($conn, $deleteAlaCarteQuery);

        $deleteOrderQuery = "DELETE FROM order_table WHERE ordr_id = '$orderID'";
        mysqli_query($conn, $deleteOrderQuery);

        // INCREMENT STOCKS AFTER DELETE
        $updateStocksQuery = "UPDATE stocks SET quantity = quantity + $sideQuantity WHERE stocks_id = '$stocksID'";
        mysqli_query($conn, $updateStocksQuery);

        header("Refresh:0");
    }

    if (isset($_POST['confirmSide'])) { 

        $orderID = $_POST['order_id'];
        $newQuantity = $_POST['sideQuan'];

        // Retrieve Stocks ID
        $stocksIDQuery = "SELECT stocks_id FROM sides
        JOIN item ON sides.sides_id = item.item_id
        JOIN order_table ON item.item_id = order_table.item_id WHERE ordr_id = '$orderID'";
        $stocksIDResult = mysqli_query($conn, $stocksIDQuery);
        $stocksIDRow = mysqli_fetch_assoc($stocksIDResult);
        $stocksID = $stocksIDRow['stocks_id'];



        $updateAlaCarteQuery = "UPDATE order_table SET ordr_quan = '$newQuantity' WHERE ordr_id = '$orderID'";
        mysqli_query($conn, $updateAlaCarteQuery);

        if ($newQuantity < $sideQuantity) { // Increment / Decrement Stocks Based on User Action
            
            $incrementQuantity = $sideQuantity - $newQuantity;
            $updateStocksQuery = "UPDATE stocks SET quantity = quantity + $incrementQuantity WHERE stocks_id = '$stocksID'";
            mysqli_query($conn, $updateStocksQuery);
        } 
            
        else if ($newQuantity > $sideQuantity) {
        
        $decrementQuantity = $newQuantity - $sideQuantity;
        $updateStocksQuery = "UPDATE stocks SET quantity = quantity - $decrementQuantity WHERE stocks_id = '$stocksID'";
        mysqli_query($conn, $updateStocksQuery);
        }

        header("Location: {$_SERVER['PHP_SELF']}");
    }

    if (isset($_POST['deleteAlaDrink'])) {

        $orderID = $_POST['order_id'];
        $drinkQuantity = $_POST['drinkQuan'];

        $stocksIDQuery = "SELECT stocks_id FROM drinks
        JOIN item ON drinks.drinks_id = item.item_id
        JOIN order_table ON item.item_id = order_table.item_id WHERE ordr_id = '$orderID'";
        $stocksIDResult = mysqli_query($conn, $stocksIDQuery);
        $stocksIDRow = mysqli_fetch_assoc($stocksIDResult);
        $stocksID = $stocksIDRow['stocks_id'];

        $deleteAlaCarteQuery = "DELETE FROM ala_carte WHERE ordr_id = '$orderID'";
        mysqli_query($conn, $deleteAlaCarteQuery);

        $deleteOrderQuery = "DELETE FROM order_table WHERE ordr_id = '$orderID'";
        mysqli_query($conn, $deleteOrderQuery);

        // INCREMENT STOCKS AFTER DELETE
        $updateStocksQuery = "UPDATE stocks SET quantity = quantity + $drinkQuantity WHERE stocks_id = '$stocksID'";
        mysqli_query($conn, $updateStocksQuery);

        header("Refresh:0");
    }

    if (isset($_POST['confirmDrink'])) { 

        $orderID = $_POST['order_id'];
        $newQuantity = $_POST['drinkQuan'];

        // Retrieve Stocks ID
        $stocksIDQuery = "SELECT stocks_id FROM drinks
        JOIN item ON drinks.drinks_id = item.item_id
        JOIN order_table ON item.item_id = order_table.item_id WHERE ordr_id = '$orderID'";
        $stocksIDResult = mysqli_query($conn, $stocksIDQuery);
        $stocksIDRow = mysqli_fetch_assoc($stocksIDResult);
        $stocksID = $stocksIDRow['stocks_id'];

            $updateAlaCarteQuery = "UPDATE order_table SET ordr_quan = '$newQuantity' WHERE ordr_id = '$orderID'";
            mysqli_query($conn, $updateAlaCarteQuery);

            if ($newQuantity < $drinkQuantity) { // Increment / Decrement Stocks Based on User Action
                
                $incrementQuantity = $drinkQuantity - $newQuantity;
                $updateStocksQuery = "UPDATE stocks SET quantity = quantity + $incrementQuantity WHERE stocks_id = '$stocksID'";
                mysqli_query($conn, $updateStocksQuery);

            } 
                
            else if ($newQuantity > $drinkQuantity) {
            
                $decrementQuantity = $newQuantity - $drinkQuantity;
                $updateStocksQuery = "UPDATE stocks SET quantity = quantity - $decrementQuantity WHERE stocks_id = '$stocksID'";
                mysqli_query($conn, $updateStocksQuery);
            }

        header("Location: {$_SERVER['PHP_SELF']}");
    }
                
        // FOR COMBOS
        if (isset($_POST['delete_combo'])) { // If the delete button is clicked
            
            $comboID = $_POST['combo_id']; // Retrieve the combo ID, mains, sides and drinks to be deleted
            $mainID = $_POST['main_id'];
            $sideID = $_POST['side_id'];
            $drinkID = $_POST['drink_id'];

            // Set main Order ID for deletion later on
            $mainOrderIDQuery = "SELECT ordr_id FROM cmb_main WHERE c_main_id = '$mainID'";
            $mainOrderIDResult = mysqli_query($conn, $mainOrderIDQuery);

            $mainOrderIDRow = mysqli_fetch_assoc($mainOrderIDResult);
            $mainOrderID = $mainOrderIDRow['ordr_id'];

            // Set side Order ID for deletion later on
            $sideOrderIDQuery = "SELECT ordr_id FROM cmb_side WHERE c_side_id = '$sideID'";
            $sideOrderIDResult = mysqli_query($conn, $sideOrderIDQuery);

            $sideOrderIDRow = mysqli_fetch_assoc($sideOrderIDResult);
            $sideOrderID = $sideOrderIDRow['ordr_id'];

            // Set drink Order ID for deletion later on
            $drinkOrderIDQuery = "SELECT ordr_id FROM cmb_drink WHERE c_drink_id = '$drinkID'";
            $drinkOrderIDResult = mysqli_query($conn, $drinkOrderIDQuery);

            $drinkOrderIDRow = mysqli_fetch_assoc($drinkOrderIDResult);
            $drinkOrderID = $drinkOrderIDRow['ordr_id'];

            // INCREMENT STOCKS FOR TO BE DELETED ORDERS
            // Get stocks_id for main 
            $getMainStocksID = "SELECT i.item_id, s.stocks_id  
            FROM order_table ot
            JOIN item i ON ot.item_id = i.item_id 
            JOIN mains m ON i.item_id = m.mains_id
            JOIN stocks s ON m.stocks_id = s.stocks_id
            WHERE ot.ordr_id = '$mainOrderID'";

            $mainResult = mysqli_query($conn, $getMainStocksID);
            $mainRow = mysqli_fetch_assoc($mainResult);
            $mainStocksID = $mainRow['stocks_id'];

            // Increment quantity in stocks table for main
            $incrementMainStock = "UPDATE stocks SET quantity = quantity + 1 WHERE stocks_id = '$mainStocksID'";
            mysqli_query($conn, $incrementMainStock);


            // Get stocks_id for side
            $getSideStocksID = "SELECT i.item_id, s.stocks_id  
            FROM order_table ot
            JOIN item i ON ot.item_id = i.item_id 
            JOIN sides sd ON i.item_id = sd.sides_id
            JOIN stocks s ON sd.stocks_id = s.stocks_id
            WHERE ot.ordr_id = '$sideOrderID'";

            $sideResult = mysqli_query($conn, $getSideStocksID);
            $sideRow = mysqli_fetch_assoc($sideResult);
            $sideStocksID = $sideRow['stocks_id'];

            // Increment quantity in stocks table for side  
            $incrementSideStock = "UPDATE stocks SET quantity = quantity + 1 WHERE stocks_id = '$sideStocksID'";
            mysqli_query($conn, $incrementSideStock);


            // Get stocks_id for drink
            $getDrinkStocksID = "SELECT i.item_id, s.stocks_id  
            FROM order_table ot
            JOIN item i ON ot.item_id = i.item_id 
            JOIN drinks d ON i.item_id = d.drinks_id
            JOIN stocks s ON d.stocks_id = s.stocks_id
            WHERE ot.ordr_id = '$drinkOrderID'";

            $drinkResult = mysqli_query($conn, $getDrinkStocksID);
            $drinkRow = mysqli_fetch_assoc($drinkResult);
            $drinkStocksID = $drinkRow['stocks_id'];

            // Increment quantity in stocks table for drink
            $incrementDrinkStock = "UPDATE stocks SET quantity = quantity + 1 WHERE stocks_id = '$drinkStocksID'"; 
            mysqli_query($conn, $incrementDrinkStock);


            // DELETE ORDERS
            // Delete the combo from the combo table
            $delCmbQuery = "DELETE FROM combo WHERE cmb_id = '$comboID';";
            mysqli_query($conn, $delCmbQuery); // Delete the combo from the combo table

            // Delete cmb_main , cmb_side, and cmb_drink
            $delCmbMainQuery = "DELETE FROM cmb_main WHERE c_main_id = '$mainID';";
            mysqli_query($conn, $delCmbMainQuery); // Delete the mains from the combo table

            $delCmbSideQuery = "DELETE FROM cmb_side WHERE c_side_id = '$sideID';";
            mysqli_query($conn, $delCmbSideQuery); // Delete the sides from the combo table

            $delCmbDrinkQuery = "DELETE FROM cmb_drink WHERE c_drink_id = '$drinkID';";
            mysqli_query($conn, $delCmbDrinkQuery); // Delete the drinks from the combo table


            // Delete main order from order table
            $deleteMainQuery = "DELETE FROM order_table WHERE ordr_id = '$mainOrderID';";
            mysqli_query($conn, $deleteMainQuery); // Delete the main order from the order table

            // Delete side order
            $deleteSideQuery = "DELETE FROM order_table WHERE ordr_id = '$sideOrderID'";
            mysqli_query($conn, $deleteSideQuery);

            // Delete drink order
            $deleteDrinkQuery = "DELETE FROM order_table WHERE ordr_id = '$drinkOrderID'";
            mysqli_query($conn, $deleteDrinkQuery);

            header("Refresh:0");
        }
    ?>

<form method="post" action="processOrders.php"> <!-- Form to save changes, PLEASE EDIT TO CORRECT FILENAME -->

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // This code won't run until the DOM is fully loaded
                        var confirmCancelBtn = document.getElementById('confirmCancel');
                        if (confirmCancelBtn) {
                            confirmCancelBtn.addEventListener('click', function() {
                                window.location.href = 'cart.php';
                            });
                        }
                    });
                </script>

                <!-- Cancel Order Confirmation Prompt -->
                <div class="modal fade" id="cancelConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLongTitle">Cancel Order</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to cancel your order and go back? All unsaved changes will be lost.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="home-keep" data-dismiss="modal">No</button>
                            <button type="button" class="home-delete" id="confirmCancel">Yes, Discard all changes</button>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="buttons-box">
                    <a href="#" data-toggle="modal" data-target="#cancelConfirmationModal">
                    <button class="edit-cart" type="button">Back</button></a> <!-- Back button with confirmation -->
                    <button class="proceed" type="submit" name="save_changes">Save</button> <!-- Save button -->                
                </div>
            </form> <!-- END OF FORM -->

    <?php
    function displayCombo($conn, $cartID) {

        // FOR COMBOS
        // Query to get mains, sides, & drinks name and price. 
        $displayComboQuery = "SELECT c.*, main.`name` AS mainName, main.price AS mainPrice, side.`name` AS sideName, side.price AS sidePrice,
                                drink.names AS drinkName, drink.price AS drinkPrice
                                FROM combo c
                                JOIN cmb_main AS cmb_m 
                                    ON cmb_m.c_main_id = c.c_main_id
                                JOIN cmb_side AS cmb_s 
                                    ON cmb_s.c_side_id = c.c_side_id
                                JOIN cmb_drink AS cmb_d 
                                    ON cmb_d.c_drink_id = c.c_drink_id
                                JOIN order_table AS ot_m 
                                    ON cmb_m.ordr_id = ot_m.ordr_id
                                JOIN order_table AS ot_s 
                                    ON cmb_s.ordr_id = ot_s.ordr_id
                                JOIN order_table AS ot_d 
                                    ON cmb_d.ordr_id = ot_d.ordr_id
                                JOIN item i_m 
                                    ON i_m.item_id = ot_m.item_id
                                JOIN item i_s 
                                    ON i_s.item_id = ot_s.item_id
                                JOIN item i_d 
                                    ON i_d.item_id = ot_d.item_id
                                JOIN sides AS side
                                    ON i_s.item_id = side.sides_id
                                JOIN mains AS main 
                                    ON i_m.item_id = main.mains_id
                                JOIN drinks AS drink 
                                    ON i_d.item_id = drink.drinks_id
                                    WHERE c.cart_id = '$cartID';";

        $displayComboResult = mysqli_query($conn, $displayComboQuery);

        while ($comboRow = mysqli_fetch_assoc($displayComboResult)) { // Loop through each row in combo table created

            $mainName = $comboRow['mainName'];      // Get the item data from the query
            $mainPrice = $comboRow['mainPrice'];    // Name and price of items in combos
            $sideName = $comboRow['sideName'];
            $sidePrice = $comboRow['sidePrice'];
            $drinkName = $comboRow['drinkName'];
            $drinkPrice = $comboRow['drinkPrice'];

            $cartID =  $comboRow['cart_id'];
            $comboID = $comboRow['cmb_id'];
            $mainID = $comboRow['c_main_id'];
            $sideID = $comboRow['c_side_id'];
            $drinkID = $comboRow['c_drink_id'];

            $totalForCombo = $mainPrice + $sidePrice + $drinkPrice;
            $discountForCombo = $totalForCombo * 0.15;
            $totalAfterDiscount = $totalForCombo - $discountForCombo;

            // ------------------ COMBO MEALS UI ------------------ 
            
            echo "<div class='cart-item-box'>";
                echo "<div class='combo-meal-box'>COMBO MEAL";

                        echo '<form method="post">';
                        echo '<input type="hidden" name="combo_id" value="'.$comboID.'">'; 
                        echo '<input type="hidden" name="main_id" value="'.$mainID.'">'; 
                        echo '<input type="hidden" name="side_id" value="'.$sideID.'">';
                        echo '<input type="hidden" name="drink_id" value="'.$drinkID.'">';
                        echo "<button type='submit' class='x-button' name='delete_combo' style='float: right; '>X</button>";
                        echo '</form>';
                    echo "<div class='order-item'>";
                        echo "<table>";
                            echo "<tr>";
                                echo "<td>$mainName</td>";
                                echo "<td>x1</td>";
                                echo "<td>PHP " . number_format($mainPrice, 2) ."</td>";
                            echo "</tr>";

                            echo "<tr>";
                                echo "<td>$sideName</td>";
                                echo "<td>x1</td>";
                                echo "<td>PHP " . number_format($sidePrice, 2) ."</td>";
                            echo "</tr>";

                            echo "<tr>";
                                echo "<td>$drinkName</td>";
                                echo "<td>x1</td>";
                                echo "<td>PHP " . number_format($drinkPrice, 2) ."</td>";
                            echo "</tr>";
                        echo "</table>";
                        echo "<hr>";
                        echo "<div class='orig-price'>";
                            echo "<table>";
                                echo "<tr>";
                                    echo "<td></td>";
                                    echo "<td></td>";
                                    echo "<td>PHP " . number_format($totalForCombo,2) ."</td>";
                                echo "</tr>";
                            echo "</table>";
                        echo "</div>";

                        echo "<div class='price'>";
                            echo "<table>";
                                echo "<tr>";
                                    echo "<td></td>";
                                    echo "<td>-15%</td>";
                                    echo "<td>PHP " . number_format($totalAfterDiscount,2) ."</td>";
                                echo "</tr>";
                            echo "</table>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";
            
            global $totalBill;
            $totalBill += $totalAfterDiscount; // Store subtotal in session variable. Gets added to after each loop iteration if more than 1 combo exists.
        }

        return $comboRow = mysqli_fetch_assoc($displayComboResult);
    }

    function displayAlacarte($conn, $cartID) {

        // FOR ALA CARTE ITEMS
        // Query to get all ala_carte items across the different cmb tables; where the cartID matches
        $alaCarteQuery = "SELECT ac.*, ot.ordr_quan AS quantity,  
                            mains.`name` AS mainName, mains.price AS mainPrice,
                            side.`name` AS sideName, side.price AS sidePrice,
                            drink.names AS drinkName, drink.price AS drinkPrice
                            FROM ala_carte ac
                            JOIN order_table ot ON ac.ordr_id = ot.ordr_id 
                            JOIN item i ON ot.item_id = i.item_id
                            LEFT JOIN sides side ON i.item_id = side.sides_id  
                            LEFT JOIN mains mains ON i.item_id = mains.mains_id
                            LEFT JOIN drinks drink ON i.item_id = drink.drinks_id
                            WHERE ac.cart_id = '$cartID'";
        
        return $displayAlacarteResult = mysqli_query($conn, $alaCarteQuery);
    }
    ?>

    <script> // Reference: https://stackoverflow.com/questions/17642872/refresh-page-and-keep-scroll-position
        window.onload = function() {
            // Save scroll position
            var scrollPos = sessionStorage.getItem('scrollPos');
            if (scrollPos) {
                window.scrollTo(0, scrollPos);
                sessionStorage.removeItem('scrollPos');
            }

            // Save scroll position before refresh
            window.onbeforeunload = function() {
                sessionStorage.setItem('scrollPos', window.scrollY);
            };
        };
    </script>
</body>
</html>