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

    <?php
        header("refresh: 5; URL=processOrders.php"); //Refresh page every 5 seconds to reflect combo changes
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
    </style>
</head>
<body>
    <?php
        session_start();
        require_once("order.php"); //Adding the order class for OOP purposes

        //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
        $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");

        $cartID = $_SESSION['cartID']; // Get the cart ID of the current user
        $totalBill = 0; // Initialize total bill as zero
    ?>

    <div class="navigation-bar">
        <ul>
            <li><a href="cancelOrder.php">
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
        <div class="select-text">CART</div>
            
            <?php displayCombo($conn, $cartID); ?> 
            
            <?php
                // Places Individual Ala Carte Items in Separate cart-item-boxes
                $displayAlacarteResult = displayAlacarte($conn, $cartID); // Get Ala Carte Items from DB
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
                        echo "<div class='cart-item-box'> Main: $mainName - Php $mainPrice * $quantity = Php $totalMainPrice<br> </div>";
                    }

                    if ($sideName != NULL) { // If the order is a side   

                        $totalSidePrice = $sidePrice * $quantity; // Calculate total price for side
                        echo "<div class='cart-item-box'> Sides: $sideName - Php $sidePrice * $quantity = Php $totalSidePrice<br> </div>";
                    }

                    if ($drinkName != NULL) { // If the order is a drink
                    
                        $totalDrinkPrice = $drinkPrice * $quantity; // Calculate total price for drink
                        echo "<div class='cart-item-box'> Drinks: $drinkName - Php $drinkPrice * $quantity = Php $totalDrinkPrice<br> </div>";
                    }
                }
            ?>
            
            <div class="cart-item-box"> <!-- Display Total For AlaCarte -->
                <?php 
                    $totalForAlacarte = displayTotalAlacarte($conn, $cartID); 
                    echo "Subtotal for Ala Carte: Php $totalForAlacarte <br><br>"; // Subtotal after all ala carte entries
                ?> 
            </div>

            <div class="cart-item-box"> <!-- Display Total For Whole Order -->
                <?php 
                    $totalBill += $totalForAlacarte;
                    echo "Total for Whole Transaction: Php $totalBill"; // Total bill from combos + ala_carte saved in session

                    $_SESSION['totalBill'] = $totalBill;
                ?> 
            </div>

            <!-- -------- Ala Carte Items UI -------- -->
            <!-- use this template for every ala carte item that was ordered -->
            <div class="cart-item-box"> 
                <div class="ala-carte-item">
                    <table>
                        <tr>
                            <td>Rice</td>
                            <td>x2</td>
                            <td>PHP 10.99</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- up to this (ala carte item)-->
            <div class="cart-item-box">
                <div class="ala-carte-item">
                    <table>
                        <tr>
                            <td>Iced Tea</td>
                            <td>x2</td>
                            <td>PHP 50.75</td>
                        </tr>
                    </table>
                </div>
            </div>
            <hr>
            <div class="cart-item-box"> 
                <div class="price-total">
                    <table>
                        <tr>
                            <td></td>
                            <td>TOTAL</td>
                            <td>PHP 200.00</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- ---------------- TO EDIT -------------------->

            <!-- <br><a href="editOrder.php">Edit Order</a>
            <br><a href="payOptions.php">Proceed to Payment</a> -->
            <div class="buttons-box">
                <a class="edit-cart" href="editOrder.php">Edit Order</a>
                <a class="proceed" href="payOptions.php">Proceed to Payment</a>
            </div>
        </div>
    </div>
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

                $totalForCombo = $mainPrice + $sidePrice + $drinkPrice;
                $discountForCombo = $totalForCombo * 0.15;
                $totalAfterDiscount = $totalForCombo - $discountForCombo;

                // ------------------ COMBO MEALS UI ------------------ 
                
                echo "<div class='cart-item-box'>";
                    echo "<div class='combo-meal-box'>COMBO MEAL";
                        echo "<div class='order-item'>";
                            echo "<table>";
                                echo "<tr>";
                                    echo "<td>$mainName</td>";
                                    echo "<td>x1</td>";
                                    echo "<td>PHP $mainPrice</td>";
                                echo "</tr>";

                                echo "<tr>";
                                    echo "<td>$sideName</td>";
                                    echo "<td>x1</td>";
                                    echo "<td>PHP $sidePrice</td>";
                                echo "</tr>";

                                echo "<tr>";
                                    echo "<td>$drinkName</td>";
                                    echo "<td>x1</td>";
                                    echo "<td>PHP $drinkPrice</td>";
                                echo "</tr>";
                            echo "</table>";
                            echo "<hr>";
                            echo "<div class='orig-price'>";
                                echo "<table>";
                                    echo "<tr>";
                                        echo "<td></td>";
                                        echo "<td></td>";
                                        echo "<td>PHP $totalForCombo</td>";
                                    echo "</tr>";
                                echo "</table>";
                            echo "</div>";

                            echo "<div class='price'>";
                                echo "<table>";
                                    echo "<tr>";
                                        echo "<td></td>";
                                        echo "<td>-15%</td>";
                                        echo "<td>PHP $totalAfterDiscount</td>";
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

        function displayTotalAlacarte($conn, $cartID) {

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

            return $totalForAlacarte = $alaCarteTotalRow['total_earned_from_alacarte'];
        }
    ?>

</body>
</html>