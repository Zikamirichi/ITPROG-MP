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

        .cart-main-box {
            background-color: #CED3D7;
            margin-left: 5%;
            margin-right: 5%;
            border-radius: 15px;
            padding-top: 10px;
            padding-bottom: 10px;
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

        /* The Modal (background) */
        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
        background-color: #fefefe;
        margin: 3% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
        }

        /* Close Button */
        .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        }

        .close:hover,
        .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            color: #ffffff; /* Text color */
            text-align: center;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: #fd7e14; /* Orange background color */
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            text-decoration: none;
        }

        .btn:hover {
            color: #ffffff;
            background-color: #ff9900; /* Lighter shade of orange on hover */
            border-color: #ff9900; /* Lighter shade of orange on hover */
        }

        

        /* TO DO:
        - Divide cart-item-box into 3 parts (dish title, quantity, price)
        - design for combo meal title
        - create for total
        - create - and + for quantity
        - create confirm and cancel buttons
        - integrate with prompt messages */
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
            <li><a href="homepage.php">
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
        <div class="cart-main-box">
            <div class="cart-item-box"> <!-- Display Combo Items in one box -->
                <?php displayCombo($conn, $cartID); ?> 
            </div>
            
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

            <br><a href="payOptions.php">Proceed to Payment</a>
            <button id="openModalBtn">Edit Order</button>

            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="right-container">
                        <div class="select-text">EDIT CART</div>
                            <div class="cart-main-box">
                            <?php

                            //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
                                        $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
                                        mysqli_select_db($conn, "mydb");

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
                                        echo "<div><br><a href='processOrders.php' class='btn btn-orange'>Back to Cart</a></div>";
                                        echo '</div>';
                                
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) { // Reference: https://stackoverflow.com/questions/17642872/refresh-page-and-keep-scroll-position
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };

        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("openModalBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        btn.onclick = function() {
        modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
        modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
        }

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

            echo "<p>Combo Items</p>";
            $comboNum = 1; // Initialize combo number as 1

            while ($comboRow = mysqli_fetch_assoc($displayComboResult)) { // Loop through each row in combo table created

                echo "<br>Combo #" . $comboNum . "<br><br>"; // Show which combo is displayed
                
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
                
                global $totalBill;
                $totalBill += $totalAfterDiscount; // Store subtotal in session variable. Gets added to after each loop iteration if more than 1 combo exists.
                $comboNum++; // Increment the shown comboNum
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