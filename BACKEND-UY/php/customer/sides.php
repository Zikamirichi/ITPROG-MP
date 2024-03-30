<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/navbar.css" />
    <link rel="stylesheet" type="text/css" href="../../css/dish.css" />
    <title>Side Dishes</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('../../images/menubg.png'); 
            background-size: cover;
            background-position: center;
            display: flex;
        }

        /* Timmy's implementation. If may better kayong UI please change hehe */

        .item .facts { /* Nutrition facts about specific item */
            visibility: hidden; /* Hidden before hovering */
            width: 300px;
            background-color: lightgrey;
            color: black;
            text-align: left;
            border-radius: 6px;
            padding: 5px 0;

            position: absolute;
            z-index: 1; /* Display above other images */
            top: 50%;
            left: 110%;
            transform: translateY(-50%); 
            box-shadow: 0 0 5px;
        }

        .item:hover .facts { /* Upon hover of item, make nutrition facts visible */
            visibility: visible;
        }

        .hidden-div {
            display: none;
            position: absolute;
            length: 50%;
            width: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: lightgrey;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
    </style>
</head>
<body>

    <?php
        error_reporting(E_ERROR | E_PARSE);
        //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
        $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");

        session_start(); // Start session to store sides objects
        require_once("order.php"); //Adding the order class for OOP purposes
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

                <li><a href="sides.php" class="active">
                    <div class="navbar-icon">
                        <img src="../../images/white-side-button.png" alt="Side Dishes">
                    </div>
                </a></li>
                <li><a href="drinks.php">
                    <div class="navbar-icon">
                        <img src="../../images/white-drink-button.png" alt="Drinks">
                    </div>
                </a></li>
                <li><a href="processOrders.php">
                    <div class="navbar-icon">
                        <img src="../../images/white-cart-button.png" alt="Cart">
                    </div>
                </a></li>
            </ul>
        </div>

    <div class="right-container">
        <div class="select-text">SIDE DISHES</div>
        
        <div class="dish-main-box">
            <?php
                $sideDishesQuery = mysqli_query($conn, "SELECT * FROM sides"); // Fetch all side dishes
                while ($sideDish = mysqli_fetch_assoc($sideDishesQuery)) { // Iterate over each side dish
            ?>
            <div class="dish-item item" onclick="showHiddenDiv('<?php echo $sideDish['sides_id']; ?>')"> <!-- Onclick for hidden div -->
                <div class="dish-img-box">
                    <?php
                        if ($sideDish['name'] == "Rice") { // If the sides are either chicken or salad, use those images

                            echo "<img src='../../images/rice.jpg' alt='" . $sideDish['name'] . "'>";
                        }

                        else if ($sideDish['name'] == "Mixed Vegetables") {

                            echo "<img src='../../images/mixed-vegetables.jpg' alt='" . $sideDish['name'] . "'>";
                        }

                        else if ($sideDish['name'] == "Mashed Potatoes") {

                            echo "<img src='../../images/mashed-potatoes.jpg' alt='" . $sideDish['name'] . "'>";
                        }

                        else {
                            echo "<img src='../../images/generic-sides.jpg' alt='" . $sideDish['name'] . "'>";
                        }
                    ?>
                </div>

                <div class="dish-title"><?php echo $sideDish['name']; ?></div>
                <div class="dish-desc"><?php echo getSideDesc($conn, $sideDish['nutr_facts_id']); ?></div>
                <div class="dish-price"><?php echo "PHP " . $sideDish['price'] . ".00"; ?></div>

                <span class="facts">
                    <?php echo getSideFacts($conn, $sideDish['nutr_facts_id']); ?>
                </span>
            </div>
            <?php
                }?>
        </div>
    </div>

    <?php
        // Loop through all sides in the table
        $sidesResult = mysqli_query($conn, "SELECT * FROM sides"); // Fetch all side dishes
        while ($row = mysqli_fetch_assoc($sidesResult)) {

            $sideID = $row['sides_id'];
            $name = $row['name'];
            $stockID = $row['stocks_id'];
        
            // Get max stock
            $stockQuery = "SELECT quantity FROM stocks WHERE stocks_id='$stockID'";
            $stockResult = mysqli_query($conn, $stockQuery);
            $stockRow = mysqli_fetch_assoc($stockResult);
            $maxStock = $stockRow['quantity'];
        
            // Hidden div
            echo "<div id='$sideID' class='hidden-div'>";
                echo "<h2>$name</h2>";
                
                if ($name == "Rice") { // If the sides are either chicken or salad, use those images

                    // Limit style to 10%, may edit later
                    echo "<img src='../../images/rice.jpg' alt='" . $name . "' style='width: 10%; height: 10%;'>";
                }

                else if ($name == "Mixed Vegetables") {

                    echo "<img src='../../images/mixed-vegetables.jpg' alt='" . $name . "' style='width: 10%; height: 10%;'>";
                }

                else if ($name == "Mashed Potatoes") {

                    echo "<img src='../../images/mashed-potatoes.jpg' alt='" . $name . "' style='width: 10%; height: 10%;'>";
                }

                else {
                    echo "<img src='../../images/generic-sides.jpg' alt='" . $name . "' style='width: 10%; height: 10%;'>";
                }
            
                echo "<div class='counter'>";
                    echo "<form method='post'>";
                        echo "<input type='hidden' name='item' value='$sideID'>";
                        echo "<input type='number' name='count' value='1' min='1' max='$maxStock'>";
                        echo "<input type='submit' name='submit'>";
                    echo "</form>";
                echo "</div>";
            echo "</div>";
        }
  ?>

    <script>
        // Function to show the hidden div based on the provided div ID
        function showHiddenDiv(divId) {
            var divToShow = document.getElementById(divId);
            if (divToShow.style.display === "none") {
                
                divToShow.style.display = "block";
            } 
            
            else {
                divToShow.style.display = "none";
            }
        }
    </script>

    <?php
        if(!isset($_SESSION['sides'])) { // Checks if a sides array has already been set (to avoid reset everytime sides.php is visited in current session)
                    
            $_SESSION['sides'] = []; // Set an array to store all sides order IDs in SESSION
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") { // When a post is done above, execute code
            
            if(isset($_POST["count"])) {

                $count = $_POST["count"];
            
                // Get max order ID
                $maxOrderQuery = "SELECT MAX(CAST(SUBSTRING(ordr_id, 2) AS UNSIGNED)) AS max_orderID FROM order_table";
                $maxResult = mysqli_query($conn, $maxOrderQuery);
                $maxRow = mysqli_fetch_assoc($maxResult);
                $maxOrderID = $maxRow['max_orderID'];
            
                $orderID = "o" . ($maxOrderID + 1);
            
                $sideID = $_POST["item"]; // Get $sideID
            
                $order = new Order($orderID); 
                $order->setOrder($count, $sideID); // Set new order
            
                // Output for testing REMOVE LATER
                echo "Order ID: " . $order->getOrderID() . "<br>";
                echo "Quantity: " . $order->getQuantity() . "<br>";
                echo "Item ID: " . $sideID . "<br>";
              }
            
            
            if(isset($_POST["submit"])) { // Execute upon submit button click
                $ordr_id = $order->getOrderID(); // Getters for order info to be inserted into the database
                $quantity = $order->getQuantity();
                $item_id = $order->getItemID();
            
                error_reporting(E_ERROR | E_PARSE);
                
                // Insert data into order table
                $insert = "INSERT INTO order_table VALUES ('$ordr_id', '$quantity', '$item_id')";
                mysqli_query($conn, $insert);

                // Update stocks table based on item ID with order quantity
                $updateSidesStock = "UPDATE stocks s
                                        JOIN sides i ON s.stocks_id = i.stocks_id
                                        SET s.quantity = s.quantity - $quantity
                                        WHERE i.sides_id = '$item_id'";
                mysqli_query($conn, $updateSidesStock); 

                array_push($_SESSION['sides'],$ordr_id); // Add order IDs to sides array in session

                echo "Record has been successfully inserted!";
                
                } else {
                    echo "Failed to insert record!!!";
                }
        }

        function getSideDesc($conn, $ntrID) {
        
            $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id = '$ntrID'"); // Displays nutrition facts of roasted chicken with id n101
            
            $factsResult = mysqli_fetch_assoc($factsQuery);

            return $factsResult['desc'];
        }

        function getSideName($conn, $sideID) {

            $nameQuery = mysqli_query($conn, "SELECT name FROM sides WHERE sides_id = '$sideID'");

            $nameResult = mysqli_fetch_assoc($nameQuery);

            return $nameResult['name'];
        }

        function getSidePrice($conn, $sideID) {

            $priceQuery = mysqli_query($conn, "SELECT price FROM sides WHERE sides_id = '$sideID'");

            $priceResult = mysqli_fetch_assoc($priceQuery);

            return "PHP " . $priceResult['price'] . ".00";
        }

        function getSideFacts($conn, $ntrID) {

            $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id = '$ntrID'"); // Displays nutrition facts of roasted chicken with id n101
            
            while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
                
                echo "Ingredients: ". $factsResult ["Ingredients"], "<br><br>";
                echo "Fat: ". $factsResult ["Fat"], "g<br>";
                echo "Calories: ". $factsResult ["Calories"], "g<br>";
                echo "Carbs: ". $factsResult ["Carbs"], "g<br>";
                echo "Protein: ". $factsResult ["Protein"], "g<br>";
            }
        }

        
    ?>
</body>
</html>
