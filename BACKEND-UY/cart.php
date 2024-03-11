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
    <title>Cart</title>
    <style>
body {
            margin: 0;
            padding: 0;
            background-image: url('images/menubg.png'); 
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center; /* Center the content horizontally */
            align-items: center; /* Center the content vertically */
        }

        nav {
            width: 200px;
            background-color: #D4471F;
            height: 100vh;
            color: white;
            padding-top: 20px;
        }

        nav a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #555;
            border-bottom: 1px solid #555;
        }

        nav a:hover {
            background-color: #F0F3F4;
        }

        nav a.current-page {
            background-color: #F0F3F4; 
            color: #555;
        }

        main {
            flex: 1;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            text-align: right
        }

        h1 {
            color: #333;
            text-align: center
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            text-decoration: underline; /* Underline text */
        }

        .cart-item span {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <nav>
        <a href="mains.php">Main</a>
        <a href="sides.php" >Sides</a>
        <a href="drink.php">Drinks</a>
        <a href="cart.php" class="current-page">Cart</a>
        <a href="mainmenu.php">Back to Hub</a>
    </nav>
    <main>
        <h1>Cart</h1>
        <?php
            session_start();
            require_once("order.php"); //Adding the order class for OOP purposes

            if (!isset($_SESSION['totalBill'])) { // For use in displaying payment later on
                $_SESSION['totalBill'] = 0;
            }

            //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
            $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
            mysqli_select_db($conn, "mydb");

            $cartID = $_SESSION['cartID']; // Get the cart ID of the current user
            echo "Current Cart ID: " . $cartID; // TESTING CART ID

            if (isset($_SESSION['mains'])) { // Check if mains were ordered by the customer
                $mains = $_SESSION['mains']; // Get the Mains currently ordered in the session
            }
            else {

                $mains = [];
            }

            if (isset($_SESSION['sides'])) { // Check if sides were ordered by the customer
                $sides = $_SESSION['sides']; // Get the Sides currently ordered in the session
            }
            else {

                $sides = [];
            }

            if (isset($_SESSION['drinks'])) { // Check if drinks were ordered by the customer
                $drinks = $_SESSION['drinks']; // Get the Drinks currently ordered in the session
            }
            else {

                $drinks = [];
            }

            // COMBO PROCESSING
            if (isset($mains, $sides, $drinks)) { // Check if there are at least 1 of each mains, sides, drinks in the order

                $combos = min(count($mains), count($sides), count($drinks)); // Get the minimum of all order types to determine the number of combos made

                for ($i = 0; $i < $combos; $i++) { // Iterate over all combos made

                    $mainOrder = $mains[$i]; 
                    $sideOrder = $sides[$i];
                    $drinkOrder = $drinks[$i];

                    // Get The Quantity of the main in the order
                    $mainQuantityQuery = "SELECT ordr_quan FROM order_table WHERE ordr_id = '$mainOrder'";
                    $mainQuantityExec = mysqli_query($conn, $mainQuantityQuery);
                    $mainQuantityFetch = mysqli_fetch_assoc($mainQuantityExec);
                    $mainQuantity = $mainQuantityFetch['ordr_quan'];

                    // Get The Quantity of the side in the order
                    $sideQuantityQuery = "SELECT ordr_quan FROM order_table WHERE ordr_id = '$sideOrder'";
                    $sideQuantityExec = mysqli_query($conn, $sideQuantityQuery);
                    $sideQuantityFetch = mysqli_fetch_assoc($sideQuantityExec);
                    $sideQuantity = $sideQuantityFetch['ordr_quan'];

                    echo $drinkOrder;
                    // Get The Quantity of the drink in the order
                    $drinkQuantityQuery = "SELECT ordr_quan FROM order_table WHERE ordr_id = '$drinkOrder'";
                    $drinkQuantityExec = mysqli_query($conn, $drinkQuantityQuery);
                    $drinkQuantityFetch = mysqli_fetch_assoc($drinkQuantityExec);
                    $drinkQuantity = $drinkQuantityFetch['ordr_quan'];

                    // Mains Queries (for cmb_main table)
                    $maxMainQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(c_main_id, 4) AS UNSIGNED)) AS maxMain FROM cmb_main"); // Query to get current max cmb_main
                    $mainFetch = mysqli_fetch_array($maxMainQuery);                                                                        // SUBSTRING 4 to remove the "cbm" part
                    $maxMainID = $mainFetch['maxMain'];
                    $nextMainID = 'cbm' . $maxMainID + 1; // Get a new cbm value by adding 1 to the max
                    
                    $mainsComboQuery = "INSERT INTO cmb_main (c_main_id, ordr_id)
                                        VALUES ('$nextMainID', '$mainOrder');"; // Query the DB to insert the main order to cmb_main
                    mysqli_query($conn, $mainsComboQuery);

                    // Sides Queries (for cmb_side table)
                    $maxSideQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(c_side_id, 4) AS UNSIGNED)) AS maxSide FROM cmb_side");
                    $sideFetch = mysqli_fetch_array($maxSideQuery);
                    $maxSideID = $sideFetch['maxSide'];
                    $nextSideID = 'cbs' . $maxSideID + 1; // Get a new cbs value by adding 1 to the max

                    $sidesComboQuery = "INSERT INTO cmb_side (c_side_id, ordr_id)
                                        VALUES ('$nextSideID', '$sideOrder')"; // Query the DB to insert the side order to cmb_side
                    mysqli_query($conn, $sidesComboQuery);

                    // Drinks Queries (for cmb_drink table)
                    $maxDrinkQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(c_drink_id, 4) AS UNSIGNED)) AS maxDrink FROM cmb_drink");
                    $drinkFetch = mysqli_fetch_array($maxDrinkQuery);
                    $maxDrinkID = $drinkFetch['maxDrink'];
                    $nextDrinkID = 'cbd' . $maxDrinkID + 1; // Get a new cbd value by adding 1 to the max

                    $drinksComboQuery = "INSERT INTO cmb_drink (c_drink_id, ordr_id)
                                        VALUES ('$nextDrinkID', '$drinkOrder')"; // Query the DB to insert the drink order to cmb_drink
                    mysqli_query($conn, $drinksComboQuery);

                    // Combo Table Queries
                    $maxComboQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(cmb_id, 4) AS UNSIGNED)) AS maxComboID FROM combo"); // Get Current Maximum Combo ID
                    $comboFetch = mysqli_Fetch_array($maxComboQuery);
                    $maxComboID = $comboFetch['maxComboID'];
                    $nextComboID = 'co_' . sprintf("%02d", $maxComboID + 1); // Get the new combo ID

                    $comboQuery = "INSERT INTO combo (cmb_id, cart_id, c_main_id, c_side_id, c_drink_id)
                                    VALUES ('$nextComboID','$cartID', '$nextMainID', '$nextSideID', '$nextDrinkID')"; // Query the DB to insert the combo items to combo table
                    mysqli_query($conn, $comboQuery);

                    // For Mains
                    if ($mainQuantity > 1) { // If an order is part of the combo meal but is selected to be more than 1 quantity
                                                // For example. Chicken was selected with 2 quantity. 1 Chicken goes to a combo while the other to ala carte
                                                // Therefore, the order is split. The order is decremented so that combo only has 1 chicken,
                                                // Then a new order is created with the remaining chicken to be put in ala carte.

                        $updateComboMainQuantity = "UPDATE order_table SET ordr_quan = 1 WHERE ordr_id = '$mainOrder'"; // Update the quantity to 1 for the main to be placed in combo
                        mysqli_query($conn, $updateComboMainQuantity);

                        // Get Current Max order_id from table 
                        $maxOrderQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ordr_id, 2) AS UNSIGNED)) AS max_orderID FROM order_table");
                        $row = mysqli_fetch_assoc($maxOrderQuery); 
                        $max_orderID = $row['max_orderID'];
                        $newMainOrderID = 'o' . ($max_orderID + 1); // The order ID to be used for the new order made

                        $newMainQuantity = $mainQuantity - 1; // Subtract 1 to lessen the order that went to the combo

                        // Get Item ID from order table associated with the main order ID
                        $newMainItemQuery = "SELECT item_id FROM order_table WHERE ordr_id = '$mainOrder'";
                        $newMainItemExec = mysqli_query($conn, $newMainItemQuery);
                        $newMainItemFetch = mysqli_fetch_assoc($newMainItemExec);
                        $newMainItemID = $newMainItemFetch['item_id'];

                        $insertNewMainQuery = "INSERT INTO order_table (ordr_id, ordr_quan, item_id)
                                                VALUES ('$newMainOrderID', '$newMainQuantity', '$newMainItemID')"; // Insert the new order to order table
                        mysqli_query($conn, $insertNewMainQuery);
                    }

                    // For Sides
                    if ($sideQuantity > 1) {
                        // Update the quantity of the side order to 1 for the combo
                        $updateComboSideQuantity = "UPDATE order_table SET ordr_quan = 1 WHERE ordr_id = '$sideOrder'";
                        mysqli_query($conn, $updateComboSideQuantity);
                    
                        // Generate a new order ID for the remaining quantity
                        $maxOrderQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ordr_id, 2) AS UNSIGNED)) AS max_orderID FROM order_table");
                        $row = mysqli_fetch_assoc($maxOrderQuery);
                        $max_orderID = $row['max_orderID'];
                        $newSideOrderID = 'o' . ($max_orderID + 1); // The order ID to be used for the new order made
                    
                        $newSideQuantity = $sideQuantity - 1; // Subtract 1 to lessen the order that went to the combo
                    
                        // Get Item ID from order table associated with the side order ID
                        $newSideItemQuery = "SELECT item_id FROM order_table WHERE ordr_id = '$sideOrder'";
                        $newSideItemExec = mysqli_query($conn, $newSideItemQuery);
                        $newSideItemFetch = mysqli_fetch_assoc($newSideItemExec);
                        $newSideItemID = $newSideItemFetch['item_id'];
                    
                        // Insert the new order into the order_table
                        $insertNewSideQuery = "INSERT INTO order_table (ordr_id, ordr_quan, item_id)
                                                VALUES ('$newSideOrderID', '$newSideQuantity', '$newSideItemID')";
                        mysqli_query($conn, $insertNewSideQuery);
                    }
                    
                    if ($drinkQuantity > 1) {
                        // Update the quantity of the drink order to 1 for the combo
                        $updateComboDrinkQuantity = "UPDATE order_table SET ordr_quan = 1 WHERE ordr_id = '$drinkOrder'";
                        mysqli_query($conn, $updateComboDrinkQuantity);
                    
                        // Generate a new order ID for the remaining quantity
                        $maxOrderQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ordr_id, 2) AS UNSIGNED)) AS max_orderID FROM order_table");
                        $row = mysqli_fetch_assoc($maxOrderQuery);
                        $max_orderID = $row['max_orderID'];
                        $newDrinkOrderID = 'o' . ($max_orderID + 1); // The order ID to be used for the new order made
                    
                        $newDrinkQuantity = $drinkQuantity - 1; // Subtract 1 to lessen the order that went to the combo
                    
                        // Get Item ID from order table associated with the drink order ID
                        $newDrinkItemQuery = "SELECT item_id FROM order_table WHERE ordr_id = '$drinkOrder'";
                        $newDrinkItemExec = mysqli_query($conn, $newDrinkItemQuery);
                        $newDrinkItemFetch = mysqli_fetch_assoc($newDrinkItemExec);
                        $newDrinkItemID = $newDrinkItemFetch['item_id'];
                    
                        // Insert the new order into the order_table
                        $insertNewDrinkQuery = "INSERT INTO order_table (ordr_id, ordr_quan, item_id)
                                                VALUES ('$newDrinkOrderID', '$newDrinkQuantity', '$newDrinkItemID')";
                        mysqli_query($conn, $insertNewDrinkQuery);
                    }

                    unset($_SESSION['mains'][array_search($mainOrder, $_SESSION['mains'])]);
                    unset($_SESSION['sides'][array_search($sideOrder, $_SESSION['sides'])]);
                    unset($_SESSION['drinks'][array_search($drinkOrder, $_SESSION['drinks'])]);
                }
            }

            // Query to Delete Comboed Items fro the ala carte table. With respect to the cart id of the ala carte table
            $deleteAlacarteQuery = "DELETE FROM ala_carte
            WHERE ordr_id IN (
                SELECT ala_carte.ordr_id FROM ala_carte
                JOIN order_table ON ala_carte.ordr_id = order_table.ordr_id
                JOIN cmb_main ON order_table.ordr_id = cmb_main.ordr_id
                UNION
                SELECT ala_carte.ordr_id FROM ala_carte
                JOIN order_table ON ala_carte.ordr_id = order_table.ordr_id
                JOIN cmb_side ON order_table.ordr_id = cmb_side.ordr_id
                UNION
                SELECT ala_carte.ordr_id FROM ala_carte
                JOIN order_table ON ala_carte.ordr_id = order_table.ordr_id
                JOIN cmb_drink ON order_table.ordr_id = cmb_drink.ordr_id
            )
            AND ala_carte.cart_id = '$cartID'";
            mysqli_query($conn, $deleteAlacarteQuery);

            // Ala Carte Processing
            // Process $mains orders
            $maxAlacarteQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ala_id, 2) AS UNSIGNED)) AS maxAlacarteID FROM ala_carte"); // Get Current Maximum Ala Carte ID
            $alacarteFetch = mysqli_Fetch_array($maxAlacarteQuery);
            $maxAlacarteID = $alacarteFetch['maxAlacarteID'];

            if ($mains != NULL) {

                foreach ($mains as $orderID) { // Iterate over all main orders
                    
                    $nextAlacarteID = 'a' . sprintf("%02d", $maxAlacarteID + 1); // Get the new Ala Carte ID
    
                    $alacarteQuery = "INSERT INTO ala_carte (ala_id, ordr_id, cart_id)
                                    VALUES ('$nextAlacarteID','$orderID', '$cartID')"; // Query the DB to insert the ala carte items to ala_carte table
                    mysqli_query($conn, $alacarteQuery);
    
                    $maxAlacarteID++; // Increment max ala carte ID for next order
                }
            }

            if ($sides != NULL) {

                // Process $sides orders
                foreach ($sides as $orderID) { // Iterate over all side orders
                    
                    $nextAlacarteID = 'a' . sprintf("%02d", $maxAlacarteID + 1); // Get the new Ala Carte ID

                    $alacarteQuery = "INSERT INTO ala_carte (ala_id, ordr_id, cart_id)
                                    VALUES ('$nextAlacarteID','$orderID', '$cartID')"; // Query the DB to insert the ala carte items to ala_carte table
                    mysqli_query($conn, $alacarteQuery);

                    $maxAlacarteID++; // Increment max ala carte ID for next order
                }
            }
            
            if ($drinks != NULL) {

                // Process $drinks orders
                foreach ($drinks as $orderID) { // Iterate over all drink orders
                    
                    $nextAlacarteID = 'a' . sprintf("%02d", $maxAlacarteID + 1); // Get the new Ala Carte ID

                    $alacarteQuery = "INSERT INTO ala_carte (ala_id, ordr_id, cart_id)
                                    VALUES ('$nextAlacarteID','$orderID', '$cartID')"; // Query the DB to insert the ala carte items to ala_carte table
                    mysqli_query($conn, $alacarteQuery);

                    $maxAlacarteID++; // Increment max ala carte ID for next order
                }
            }

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

                $totalForCombo = $mainPrice + $sidePrice + $drinkPrice;
                $discountForCombo = $totalForCombo * 0.15;
                $totalAfterDiscount = $totalForCombo - $discountForCombo;

                echo "<li>Mains: $mainName - $mainPrice </li>"; // Display the mains, sides, drinks ordered in the combo with their prices
                echo "<li>Sides: $sideName - $sidePrice </li>";
                echo "<li>Drinks: $drinkName - $drinkPrice </li><br>";
                echo "Subtotal: Php $totalForCombo <br>";
                echo "Discount: Php $discountForCombo <br>";
                echo "Subtotal After Discount: Php $totalAfterDiscount <br>";
                
                $_SESSION['totalBill'] += $totalAfterDiscount; // Store subtotal in session variable. Gets added to after each loop iteration if more than 1 combo exists.
                $comboNum++; // Increment the shown comboNum
            }

            // FOR ALA CARTE ITEMS
            // Query to get all ala_carte items across the different cmb tables; where the cartID matches
            $alaCarteQuery = "SELECT ac.*, mains.`name` AS mainName, mains.price AS mainPrice, side.`name` AS sideName, side.price AS sidePrice, 
                                    drink.names AS drinkName, drink.price AS drinkPrice
                                FROM ala_carte ac
                                JOIN order_table AS ot 
                                    ON ac.ordr_id = ot.ordr_id
                                JOIN item i 
                                    ON i.item_id = ot.item_id
                                LEFT JOIN sides AS side 
                                    ON i.item_id = side.sides_id
                                LEFT JOIN mains AS mains 
                                    ON i.item_id = mains.mains_id
                                LEFT JOIN drinks AS drink 
                                    ON i.item_id = drink.drinks_id
                                WHERE ac.cart_id = '$cartID'";
            
            $displayAlacarteResult = mysqli_query($conn, $alaCarteQuery);

            echo "<h2>Ala Carte Items</h2>";
            $totalForAlacarte = 0; // Initialize total for ala carte items

            while ($alaCarteRow = mysqli_fetch_assoc($displayAlacarteResult)) { // Loop through all resulting rows in ala_carte query

                $mainName = $alaCarteRow['mainName'];       // Get Item Info from Queries
                $mainPrice = $alaCarteRow['mainPrice'];     // Name and Price of Ala Carte Items
                $sideName = $alaCarteRow['sideName'];
                $sidePrice = $alaCarteRow['sidePrice'];
                $drinkName = $alaCarteRow['drinkName'];
                $drinkPrice = $alaCarteRow['drinkPrice'];

                $totalForAlacarte = 0; // Initialize total as 0
                if ($mainName != NULL) { // If the order is a main
                    $totalForAlacarte += $mainPrice;
                    echo "Main: $mainName - Php $mainPrice <br><br>";
                }

                if ($sideName != NULL) { // If the order is a side
                    $totalForAlacarte += $sidePrice;
                    echo "Sides: $sideName - Php $sidePrice <br>";
                }

                if ($drinkName != NULL) { // If the order is a drink
                    $totalForAlacarte += $drinkPrice;
                    echo "Drinks: $drinkName - Php $drinkPrice <br>";
                }
            }
        
            echo "Subtotal for Ala Carte: Php $totalForAlacarte <br><br>"; // Subtotal after all ala carte entries

            $_SESSION['totalBill'] += $totalForAlacarte; // Add Ala carte total to whole bill
            $totalBill = $_SESSION['totalBill'];

            echo "Total for Whole Transaction: Php $totalBill"; // Total bill from combos + ala_carte saved in session
        ?>

        <a href="paid.php">Done</a>
    </main>
</body>
</html>
