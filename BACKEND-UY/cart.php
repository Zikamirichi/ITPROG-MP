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

            //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
            $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
            mysqli_select_db($conn, "mydb");

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
            $totalBill = 0;
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
                
                $totalBill += $totalAfterDiscount; // Store subtotal in session variable. Gets added to after each loop iteration if more than 1 combo exists.
                $comboNum++; // Increment the shown comboNum
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

            while ($alaCarteRow = mysqli_fetch_assoc($displayAlacarteResult)) { // Loop through all resulting rows in ala_carte query

                $mainName = $alaCarteRow['mainName'];       // Get Item Info from Queries
                $mainPrice = $alaCarteRow['mainPrice'];     // Name and Price of Ala Carte Items
                $sideName = $alaCarteRow['sideName'];
                $sidePrice = $alaCarteRow['sidePrice'];
                $drinkName = $alaCarteRow['drinkName'];
                $drinkPrice = $alaCarteRow['drinkPrice'];
                $quantity = $alaCarteRow['quantity'];

                if ($mainName != NULL) { // If the order is a main

                    $totalMainPrice = $mainPrice * $quantity; // Calculate total price for main
                    echo "Main: $mainName - Php $mainPrice * $quantity = Php $totalMainPrice<br>";
                }

                if ($sideName != NULL) { // If the order is a side   

                    $totalSidePrice = $sidePrice * $quantity; // Calculate total price for side
                    echo "Sides: $sideName - Php $sidePrice * $quantity = Php $totalSidePrice<br>";
                }

                if ($drinkName != NULL) { // If the order is a drink
                
                    $totalDrinkPrice = $drinkPrice * $quantity; // Calculate total price for drink
                    echo "Drinks: $drinkName - Php $drinkPrice * $quantity = Php $totalDrinkPrice<br>";
                }
            }

            // Query to get total for ala carte items relative to cart ID
            $alaCarteTotalQuery = "SELECT 
            SUM(COALESCE(mains.price*ot.ordr_quan, 0) + COALESCE(side.price*ot.ordr_quan, 0) + COALESCE(drink.price*ot.ordr_quan, 0)) AS total_earned_from_alacarte
            FROM 
                ala_carte ac
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
                WHERE cart_id = '$cartID';";
            
            $alaCarteTotalResult = mysqli_query($conn, $alaCarteTotalQuery); 
            $alaCarteTotalRow = mysqli_fetch_assoc($alaCarteTotalResult); // Fetch the total calculated
            
            $totalForAlacarte = $alaCarteTotalRow['total_earned_from_alacarte'];
            echo "Subtotal for Ala Carte: Php $totalForAlacarte <br><br>"; // Subtotal after all ala carte entries

            $totalBill += $totalForAlacarte;
            echo "Total for Whole Transaction: Php $totalBill"; // Total bill from combos + ala_carte saved in session
        ?>

    <br><a href="editOrder.php">Edit Order</a>
        <br><a href="paid.php">Done</a>
    </main>
</body>
</html>
