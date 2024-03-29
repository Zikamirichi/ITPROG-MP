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

    <?php
        // header("refresh: 5; URL=processOrders.php"); //Refresh page every 5 seconds to reflect combo changes
    ?>
  </head>
    <title>Edit Cart</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('../../images/menubg.png'); 
            background-size: cover;
            background-position: center;
            display: flex;
        }

        .cart-main-box {
            background-color: #CED3D7;
            margin-left: 5%;
            margin-right: 5%;
            border-radius: 15px;
            padding-top: 10px;
            padding-bottom: 50px;
        }

        .cart-item-box {
            margin: 2%;
            border-radius: 15px;
            background-color: white;
            font-family: "Luckiest Guy", cursive;
            font-weight: 400;
            font-style: normal;
            font-size: 23px;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
            position: relative;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            color: #fff; /* changed color to white */
            text-align: center;
            vertical-align: middle;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            text-decoration: none; /* Remove underline */
            margin: 15px 0;
        }

        .btn-orange {
            background-color: #ff7f0f; /* changed background color to orange */
            border-color: #ff7f0f; /* changed border color to orange */
            float: right; /* aligned button to the right */
            margin-top: 25px;
        }

        .btn-orange:hover {
            background-color: #e65c00; /* changed hover background color to a darker shade of orange */
            border-color: #e65c00; /* changed hover border color to a darker shade of orange */
        }

        .btn-orange:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 127, 15, 0.5); /* changed focus box-shadow color to orange */
        }

        .btn-red {
            background-color: #dc3545; /* Red color */
            border-color: #dc3545; /* Red color */
        }

        .btn-red:hover {
            background-color: #c82333; /* Darker shade of red */
            border-color: #bd2130; /* Darker shade of red */
        }

        .btn-red:focus {
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.5); /* Red color */
        }
       
    </style>
</head>
<body>
    <div class="right-container">
    <div class="select-text">EDIT CART</div>
    <div class="cart-main-box">
    <?php

    //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
                $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
                mysqli_select_db($conn, "mydb");

                session_start();

                $cartID = $_SESSION['cartID']; // Get the cart ID of the current user
                echo '<div class="cart-item-box" style="width: 25%">';
                echo "Current Cart ID: " . $cartID; // TESTING CART ID
                echo '</div>';
                
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

                echo '<div class="cart-item-box">';
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
                        echo '<button type="submit" name="delete_combo" class="btn btn-red">Delete Combo</button>';
                        echo '</form>';

                        $comboNum++; // Increment the shown comboNum
                    }
                echo '</div>';

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

                echo '<div class="cart-item-box">';
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
                    $quantity = $alaCarteRow['quantity'];

                    $totalForAlacarte = 0; // Initialize total as 0
                    if ($mainName != NULL) { // If the order is a main
                        $totalForAlacarte += $mainPrice;

                        echo "Main: $mainName ";
                        
                        echo '<form method="post">'; // Form to change quantity of main

                        echo "<input type='number' name='mainQuan' value='$quantity' min='0'>"; 
                        echo '<input type="hidden" name="order_id" value="'.$orderID.'">';

                        echo '<button type="submit" name="confirmMain">Confirm Change</button>';

                        echo '</form>';
                    }

                    if ($sideName != NULL) { // If the order is a side
                        $totalForAlacarte += $sidePrice;

                        echo "Sides: $sideName ";
                        
                        echo '<form method="post">'; // Form to change quantity of side

                        echo "<input type='number' name='sideQuan' value='$quantity' min='0'>"; 
                        echo '<input type="hidden" name="order_id" value="'.$orderID.'">';

                        echo '<button type="submit" name="confirmMain">Confirm Change</button>';

                        echo '</form>';
                    }

                    if ($drinkName != NULL) { // If the order is a drink
                        $totalForAlacarte += $drinkPrice;

                        echo "Drink: $drinkName ";
                        
                        echo '<form method="post">'; // Form to change quantity of drink

                        echo "<input type='number' name='drinkQuan' value='$quantity' min='0'>"; 
                        echo '<input type="hidden" name="order_id" value="'.$orderID.'">';

                        echo '<button type="submit" name="confirmMain">Confirm Change</button>';

                        echo '</form>';
                    }
                }

                if (isset($_POST['confirmMain'])) { // If the user wants to change the quantity of a main item


                    $orderID = $_POST['order_id'];
                    $newQuantity = $_POST['mainQuan'];

                    if ($newQuantity == 0) { // If the user wants to delete the item

                        $deleteAlaCarteQuery = "DELETE FROM ala_carte WHERE ordr_id = '$orderID'";
                        mysqli_query($conn, $deleteAlaCarteQuery);

                        $deleteOrderQuery = "DELETE FROM order_table WHERE ordr_id = '$orderID'";
                        mysqli_query($conn, $deleteOrderQuery);

                        echo "Item Successfully Deleted!";
                    }

                    else { // If the user wants to change the quantity of the item

                        $updateAlaCarteQuery = "UPDATE order_table SET ordr_quan = '$newQuantity' WHERE ordr_id = '$orderID'";
                        mysqli_query($conn, $updateAlaCarteQuery);

                        echo "Quantity Successfully Updated!";
                    }
                }

                if (isset($_POST['confirmSide'])) { 


                    $orderID = $_POST['order_id'];
                    $newQuantity = $_POST['sideQuan'];

                    if ($newQuantity == 0) { // If the user wants to delete the item

                        $deleteAlaCarteQuery = "DELETE FROM ala_carte WHERE ordr_id = '$orderID'";
                        mysqli_query($conn, $deleteAlaCarteQuery);

                        $deleteOrderQuery = "DELETE FROM order_table WHERE ordr_id = '$orderID'";
                        mysqli_query($conn, $deleteOrderQuery);

                        echo "Item Successfully Deleted!";
                    }
                    else { // If the user wants to change the quantity of the item

                        $updateAlaCarteQuery = "UPDATE order_table SET ordr_quan = '$newQuantity' WHERE ordr_id = '$orderID'";
                        mysqli_query($conn, $updateAlaCarteQuery);

                        echo "Quantity Successfully Updated!";
                    }
                }

                if (isset($_POST['confirmDrink'])) { 

                    $orderID = $_POST['order_id'];
                    $newQuantity = $_POST['drinkQuan'];

                    if ($newQuantity == 0) { // If the user wants to delete the item

                        $deleteAlaCarteQuery = "DELETE FROM ala_carte WHERE ordr_id = '$orderID'";
                        mysqli_query($conn, $deleteAlaCarteQuery);

                        $deleteOrderQuery = "DELETE FROM order_table WHERE ordr_id = '$orderID'";
                        mysqli_query($conn, $deleteOrderQuery);

                        echo "Item Successfully Deleted!";
                    }
                    else { 

                        $updateAlaCarteQuery = "UPDATE order_table SET ordr_quan = '$newQuantity' WHERE ordr_id = '$orderID'";
                        mysqli_query($conn, $updateAlaCarteQuery);

                        echo "Quantity Successfully Updated!";
                    }
                }
                echo "<div><a href='processOrders.php' class='btn btn-orange'>Back to Cart</a></div>";
                echo '</div>';
        
    ?>
    </div>
    </div>
</body>
