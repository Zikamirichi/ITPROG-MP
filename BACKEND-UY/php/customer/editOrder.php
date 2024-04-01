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
            <form method="post" action="save_changes.php"> <!-- Form to save changes, PLEASE EDIT TO CORRECT FILENAME -->
            <div class="cart-main-box">

                <!-- --------EDIT COMBO MEAL UI------- -->
                <div class='cart-item-box'>
                    <div class='combo-meal-box'>COMBO MEAL
                        <div class='order-item'>
                            <table>
                                <tr>
                                    <td>$mainName</td>
                                    <td>x<input type='number' class="input-quantity" name='main_quantity' value='1' min='1'></td>
                                    <td>PHP $mainPrice</td>
                                    <td><button type='button' class='x-button'>X</button></td>
                                </tr>

                                <tr>
                                    <td>$sideName</td>
                                    <td>x<input type='number' class="input-quantity" name='side_quantity' value='1' min='1'></td>
                                    <td>PHP $sidePrice</td>
                                    <td><button type='button' class='x-button'>X</button></td>
                                </tr>

                                <tr>
                                    <td>$drinkName</td>
                                    <td>x<input type='number' class="input-quantity" name='drink_quantity' value='1' min='1'></td>
                                    <td>PHP $drinkPrice</td>
                                    <td><button type='button' class='x-button'>X</button></td>
                                </tr>
                            </table>
                            <hr>
                            <div class='orig-price'>
                                <table>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>PHP $totalForCombo</td>
                                    </tr>
                                </table>
                            </div>

                            <div class='price'>
                                <table>
                                    <tr>
                                        <td></td>
                                        <td>-15%</td>
                                        <td>PHP $totalAfterDiscount</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--------- COMBO MEAL EDIT END UI --------->

                <!-- ---------- ALA CARTE EDIT UI ------------- -->
                <div class='cart-item-box'>
                    <div class='ala-carte-item'>
                        <table>
                            <tr>
                                <td>$mainName</td>
                                <td>x<input type='number' class="input-quantity" name='main_quantity' value='1' min='1'></td>
                                <td>Php $totalMainPrice</td>
                                <td><button type='button' class='x-button'>X</button></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- ---------- ALA CARTE EDIT UI END------------- -->

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

    //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
                $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
                mysqli_select_db($conn, "mydb");

                session_start();

                $cartID = $_SESSION['cartID']; // Get the cart ID of the current user
                echo "Current Cart ID: " . $cartID; // TESTING CART ID
                
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

                echo "<h2>Combo Items</h2>";
                $comboNum = 1; // Initialize combo number as 1

                while ($comboRow = mysqli_fetch_assoc($displayComboResult)) { // Loop through each row in combo table created

                    echo "Combo #" . $comboNum . "<br><br>"; // Show which combo is displayed
                    
                    $mainName = $comboRow['mainName'];      // Get the item data from the query
                    $mainPrice = $comboRow['mainPrice'];    // Name and price of items in combos
                    $sideName = $comboRow['sideName'];
                    $sidePrice = $comboRow['sidePrice'];
                    $drinkName = $comboRow['drinkName'];
                    $drinkPrice = $comboRow['drinkPrice'];

                    $comboID = $comboRow['cmb_id'];          // Get the item data from the query
                    $mainID = $comboRow['c_main_id'];
                    $sideID = $comboRow['c_side_id'];
                    $drinkID = $comboRow['c_drink_id'];

                    $totalForCombo = $mainPrice + $sidePrice + $drinkPrice;
                    $discountForCombo = $totalForCombo * 0.15;
                    $totalAfterDiscount = $totalForCombo - $discountForCombo;

                    echo "<li>Mains: $mainName - $mainPrice </li>"; // Display the mains, sides, drinks ordered in the combo with their prices
                    echo "<li>Sides: $sideName - $sidePrice </li>";
                    echo "<li>Drinks: $drinkName - $drinkPrice </li><br>";
                    echo "Subtotal: Php $totalForCombo <br>";
                    echo "Discount: Php $discountForCombo <br>";
                    echo "Subtotal After Discount: Php $totalAfterDiscount <br>";
                    
                    echo '<form method="post">';
                    echo '<input type="hidden" name="combo_id" value="'.$comboID.'">'; 
                    echo '<input type="hidden" name="main_id" value="'.$mainID.'">'; 
                    echo '<input type="hidden" name="side_id" value="'.$sideID.'">';
                    echo '<input type="hidden" name="drink_id" value="'.$drinkID.'">';
                    echo '<button type="submit" name="delete_combo">Delete Combo</button>';
                    echo '</form>';

                    $comboNum++; // Increment the shown comboNum
                }

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

                    echo "Combo Successfully Deleted!";
                }

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
                
                $displayAlacarteResult = mysqli_query($conn, $alaCarteQuery);

                echo "<h2>Ala Carte Items</h2>";
                $totalForAlacarte = 0; // Initialize total for ala carte items

                while ($alaCarteRow = mysqli_fetch_assoc($displayAlacarteResult)) { // Loop through all resulting rows in ala_carte query

                    $orderID = $alaCarteRow['ordr_id'];

                    $mainName = $alaCarteRow['mainName'];       // Get Item Info from Queries
                    $mainPrice = $alaCarteRow['mainPrice'];     // Name and Price of Ala Carte Items
                    $sideName = $alaCarteRow['sideName'];
                    $sidePrice = $alaCarteRow['sidePrice'];
                    $drinkName = $alaCarteRow['drinkName'];
                    $drinkPrice = $alaCarteRow['drinkPrice'];

                    $totalForAlacarte = 0; // Initialize total as 0
                    if ($mainName != NULL) { // If the order is a main

                        $mainQuantity = $alaCarteRow['quantity'];
                        $totalForAlacarte += $mainPrice;

                        echo "Main: $mainName - ";
                        
                        echo '<form method="post">'; // Form to change quantity of main

                        echo "<input type='number' name='mainQuan' value='$mainQuantity' min='0'>"; 
                        echo '<input type="hidden" name="order_id" value="'.$orderID.'">';

                        echo '<button type="submit" name="confirmMain">Confirm Change</button>';

                        echo '</form>';
                    }

                    if ($sideName != NULL) { // If the order is a side

                        $sideQuantity = $alaCarteRow['quantity'];
                        $totalForAlacarte += $sidePrice;

                        echo "Sides: $sideName - ";
                        
                        echo '<form method="post">'; // Form to change quantity of side

                        echo "<input type='number' name='sideQuan' value='$sideQuantity' min='0'>"; 
                        echo '<input type="hidden" name="order_id" value="'.$orderID.'">';

                        echo '<button type="submit" name="confirmSide">Confirm Change</button>';

                        echo '</form>';
                    }

                    if ($drinkName != NULL) { // If the order is a drink

                        $drinkQuantity = $alaCarteRow['quantity'];
                        $totalForAlacarte += $drinkPrice;

                        echo "Drink: $drinkName - ";
                        
                        echo '<form method="post">'; // Form to change quantity of drink

                        echo "<input type='number' name='drinkQuan' value='$drinkQuantity' min='0'>"; 
                        echo '<input type="hidden" name="order_id" value="'.$orderID.'">';

                        echo '<button type="submit" name="confirmDrink">Confirm Change</button>';

                        echo '</form>';
                    }
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

                    if ($newQuantity == 0) { // If the user wants to delete the item

                        $deleteAlaCarteQuery = "DELETE FROM ala_carte WHERE ordr_id = '$orderID'";
                        mysqli_query($conn, $deleteAlaCarteQuery);

                        $deleteOrderQuery = "DELETE FROM order_table WHERE ordr_id = '$orderID'";
                        mysqli_query($conn, $deleteOrderQuery);

                        // INCREMENT STOCKS AFTER DELETE
                        $updateStocksQuery = "UPDATE stocks SET quantity = quantity + $mainQuantity WHERE stocks_id = '$stocksID'";
                        mysqli_query($conn, $updateStocksQuery);

                        echo "Item Successfully Deleted!";
                    }

                    else { // If the user wants to change the quantity of the item

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

                        echo "Quantity Successfully Updated!";
                    }

                    header("Location: {$_SERVER['PHP_SELF']}");
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

                    if ($newQuantity == 0) { // If the user wants to delete the item

                        $deleteAlaCarteQuery = "DELETE FROM ala_carte WHERE ordr_id = '$orderID'";
                        mysqli_query($conn, $deleteAlaCarteQuery);

                        $deleteOrderQuery = "DELETE FROM order_table WHERE ordr_id = '$orderID'";
                        mysqli_query($conn, $deleteOrderQuery);

                        // INCREMENT STOCKS AFTER DELETE
                        $updateStocksQuery = "UPDATE stocks SET quantity = quantity + $sideQuantity WHERE stocks_id = '$stocksID'";
                        mysqli_query($conn, $updateStocksQuery);

                        echo "Item Successfully Deleted!";
                    }

                    else { // If the user wants to change the quantity of the item

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

                        echo "Quantity Successfully Updated!";
                    }

                    header("Location: {$_SERVER['PHP_SELF']}");
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

                    if ($newQuantity == 0) { // If the user wants to delete the item

                        $deleteAlaCarteQuery = "DELETE FROM ala_carte WHERE ordr_id = '$orderID'";
                        mysqli_query($conn, $deleteAlaCarteQuery);

                        $deleteOrderQuery = "DELETE FROM order_table WHERE ordr_id = '$orderID'";
                        mysqli_query($conn, $deleteOrderQuery);

                        // INCREMENT STOCKS AFTER DELETE
                        $updateStocksQuery = "UPDATE stocks SET quantity = quantity + $drinkQuantity WHERE stocks_id = '$stocksID'";
                        mysqli_query($conn, $updateStocksQuery);

                        echo "Item Successfully Deleted!";
                    }

                    else { 

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

                        echo "Quantity Successfully Updated!";
                    }

                    header("Location: {$_SERVER['PHP_SELF']}");
                }
        
    echo "<br><br> <a href='processOrders.php'>Back to Cart</a>";
    ?>

            </div>
        </div>
    </div>
</body>
</html>