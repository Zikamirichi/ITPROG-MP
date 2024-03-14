<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side Dishes</title>
    <style>
body {
            margin: 0;
            padding: 0;
            background-image: url('images/menubg.png'); 
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            display: flex;
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
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            text-align: center;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        ul {
            list-style-type: none;
            padding: 0;
            display: flex; /* Make the list horizontal */
            justify-content: flex-start; /* Adjust the spacing */

        }
        li {
            margin-left: 50px;
            padding: 10px 0; /* Add padding for spacing */
            text-decoration: underline; /* Underline text */
            position: relative;
        }

        .item img{ /* Class for images representing item choices */
            width: 150px;
            height: 150px;
        }

        .item .facts { /* Nutrition facts about specific item */
            visibility: hidden; /* Hidden before hovering */
            width: 200px;
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

        .content { /* Hide Content */
            display: none;
        }

        .main { /* Represents Clickable Area */
            width: 150px; /* Same size as images, can be changed */
            height: 150px;
            cursor: pointer;
        }

        #rice:checked ~ .rice,
        #veg:checked ~ .veg,
        #mash:checked ~ .mash { /* Content to be shown */
            display: block;
            position: fixed;
            width: 50%;
            height: 40%;
            background-color: lightgrey;
        }

    </style>
</head>
<body>

    <?php
        error_reporting(E_ERROR | E_PARSE);
        //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
        $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");

        session_start();
        require_once("order.php"); //Adding the order class for OOP purposes
        
        // Get stocks from database for input to be limited to the available stocks
        $maxs01StockQuery = "SELECT quantity FROM stocks WHERE stocks_id ='s01';";
        $maxs01StockResult = mysqli_query($conn, $maxs01StockQuery);
        $maxs01StockRow = mysqli_fetch_assoc($maxs01StockResult);
        $maxs01Stock = $maxs01StockRow['quantity'];

        $maxs02StockQuery = "SELECT quantity FROM stocks WHERE stocks_id ='s02';";
        $maxs02StockResult = mysqli_query($conn, $maxs02StockQuery);
        $maxs02StockRow = mysqli_fetch_assoc($maxs02StockResult);
        $maxs02Stock = $maxs02StockRow['quantity'];

        $maxs03StockQuery = "SELECT quantity FROM stocks WHERE stocks_id ='s03';";
        $maxs03StockResult = mysqli_query($conn, $maxs03StockQuery);
        $maxs03StockRow = mysqli_fetch_assoc($maxs03StockResult);
        $maxs03Stock = $maxs03StockRow['quantity'];

        /* Comment out since s04 is not used.
        $maxs04StockQuery = "SELECT quantity FROM stocks WHERE stocks_id = 's04':";
        $maxs04StockResult = mysqli_query($conn, $maxs04StockQuery);
        $maxs04StockRow = mysqli_fetch_assoc($maxs04StockResult);
        $maxs04Stock = $maxs04StockRow['quantity'];
        */
    ?>

    <nav>
        <a href="mains.php">Main</a>
        <a href="sides.php" class="current-page">Sides</a>
        <a href="drink.php">Drinks</a>
        <a href="processOrders.php">Cart</a>
        <a href="mainmenu.php">Back to Hub</a>
    </nav>
    <main>
        <h1>Side Dishes</h1>
        <ul>
                <li class ="item">
                    <input type="checkbox" id="rice" hidden> <!-- Hidden checkbox is for bringing out item quantity "mini page". Refer to reference above -->
                    <label for="rice" class="main">
                        <img src="images/rice.png" alt="Steamed Rice"><br>
                        Steamed Rice
                    </label>
                    <span class = "facts">
                        <?php
                            $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id = 'n201'"); // Displays nutrition facts of rice with id n201
                            while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
                                echo $factsResult ["desc"], "<br><br>";
                                echo "Ingredients: ". $factsResult ["Ingredients"], "<br><br>";
                                echo "Fat: ". $factsResult ["Fat"], "<br>";
                                echo "Calories: ". $factsResult ["Calories"], "<br>";
                                echo "Carbs: ". $factsResult ["Carbs"], "<br>";
                                echo "Protein: ". $factsResult ["Protein"], "<br>";
                            }
                        ?>
                    </span>

                    <div class="rice content"> <!-- Div for "mini page" for selecting quantity of rice -->
                        <h2>Steamed Rice</h2>
                        <img src="images/rice.png" alt="Steamed Rice"> <br>
                        <div class="counter"> <!-- Counter for selecting the quantity of rice -->
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="item" value="rice"> <!-- Hidden value to indicate that rice was the selected item-->
                                <input type="number" id="count" name="count" value="1" min="1" max="<?php echo $maxs01Stock; ?>"> <br>
                                <input type="submit" value ="Submit" name="submit"> <!-- Submit button for finalizing order -->
                            </form>
                    </div>
                </li>
                
                <li class ="item">
                    <input type="checkbox" id="veg" hidden> <!-- Hidden checkbox is for bringing out item quantity "mini page". Refer to reference above -->
                    <label for="veg" class="main">
                        <img src="images/veg.png" alt="Mixed Vegetables"><br>
                        Mixed Vegetables
                    </label>
                    <span class = "facts">
                        <?php
                            $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id = 'n202'"); // Displays nutrition facts of veg with id n202
                            while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
                                echo $factsResult ["desc"], "<br><br>";
                                echo "Ingredients: ". $factsResult ["Ingredients"], "<br><br>";
                                echo "Fat: ". $factsResult ["Fat"], "<br>";
                                echo "Calories: ". $factsResult ["Calories"], "<br>";
                                echo "Carbs: ". $factsResult ["Carbs"], "<br>";
                                echo "Protein: ". $factsResult ["Protein"], "<br>";
                            }
                        ?>
                    </span>

                    <div class="veg content"> <!-- Div for "mini page" for selecting quantity of veg -->
                        <h2>Mixed Vegetables</h2>
                        <img src="images/veg.png" alt="Mixed Vegetables"> <br>
                        <div class="counter"> <!-- Counter for selecting the quantity of veg -->
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="item" value="veg"> <!-- Hidden value to indicate that veg was the selected item-->
                                <input type="number" id="count" name="count" value="1" min="1" max="<?php echo $maxs02Stock; ?>"> <br>
                                <input type="submit" value ="Submit" name="submit"> <!-- Submit button for finalizing order -->
                            </form>
                    </div>
                </li>
                
                <li class ="item">
                    <input type="checkbox" id="mash" hidden> <!-- Hidden checkbox is for bringing out item quantity "mini page". Refer to reference above -->
                    <label for="mash" class="main">
                        <img src="images/mash.png" alt="Mashed Potatoes"><br>
                        Mashed Potatoes
                    </label>
                    <span class = "facts">
                        <?php
                            $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id = 'n202'"); // Displays nutrition facts of veg with id n202
                            while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
                                echo $factsResult ["desc"], "<br><br>";
                                echo "Ingredients: ". $factsResult ["Ingredients"], "<br><br>";
                                echo "Fat: ". $factsResult ["Fat"], "<br>";
                                echo "Calories: ". $factsResult ["Calories"], "<br>";
                                echo "Carbs: ". $factsResult ["Carbs"], "<br>";
                                echo "Protein: ". $factsResult ["Protein"], "<br>";
                            }
                        ?>
                    </span>

                    <div class="mash content"> <!-- Div for "mini page" for selecting quantity of mash -->
                        <h2>Mashed Potatoes</h2>
                        <img src="images/mash.png" alt="Mashed Potatoes"> <br>
                        <div class="counter"> <!-- Counter for selecting the quantity of mash -->
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <input type="hidden" name="item" value="mash"> <!-- Hidden value to indicate that mash was the selected item-->
                                <input type="number" id="count" name="count" value="1" min="1" max="<?php echo $maxs03Stock; ?>"> <br>
                                <input type="submit" value ="Submit" name="submit"> <!-- Submit button for finalizing order -->
                            </form>
                    </div>
                </li>
            <!-- Add more main dishes as needed -->
        </ul>
    </main>

    <?php
        if(!isset($_SESSION['sides'])) { // Checks if a sides array has already been set (to avoid reset everytime sides.php is visited in current session)
            
            $_SESSION['sides'] = []; // Set an array to store all sides order IDs in SESSION
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") { // When a post is done above, execute code
            
            if(isset($_POST["count"])){ // Check if the count value is set
                
                $count = $_POST["count"]; // Retrieve the count value from the POST data
                
                $maxOrderQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ordr_id, 2) AS UNSIGNED)) AS max_orderID FROM order_table");
                $row = mysqli_fetch_assoc($maxOrderQuery); // Get Current Max order_id from table 
                $max_orderID = $row['max_orderID'];
                $orderNum = $max_orderID + 1;

                $order = new Order("o" . $orderNum); // Create new order with new calculated order id

                $item = $_POST["item"]; // Retreive the specific item selected

                if ($item == "rice") { 
                    
                    $order->setOrder($count, "i201"); // If submit button pressed was under rice, set itemID to i201
                }
                
                if ($item == "veg") {
                    
                    $order->setOrder($count, "i202"); // Mixed Vegetables = i202
                }

                if ($item == "mash") {
                    
                    $order->setOrder($count, "i203"); // Mashed Potatoes = i202
                }

                // TESTING REMOVE IN FINAL PRODUCT
                echo "Order ID: " . $order->getorderID() . "<br>"; 
                echo "Quantity: " . $order->getQuantity() . "<br>";
                echo "Item ID: " . $order->getItemID() . "<br>";
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
    ?>
</body>
</html>
