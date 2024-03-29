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

        session_start(); // Start session to store mains objects
        require_once("order.php"); //Adding the order class for OOP purposes

        sideStocks($conn);
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
                <li><a href="cart.php">
                    <div class="navbar-icon">
                        <img src="../../images/white-cart-button.png" alt="Cart">
                    </div>
                </a></li>
            </ul>
        </div>

    <div class="right-container">
        <div class="select-text">SIDE DISHES</div>
        <div class="dish-main-box">
            
            <div class="dish-item item" onclick="showHiddenDiv('riceDiv')">
                <div class="dish-img-box">
                    <img src="../../images/rice.jpg" alt="Rice">
                </div>

                <div class="dish-title"><?php echo getSideName($conn, 'i201') ?></div>
                <div class="dish-desc"><?php echo getSideDesc($conn,'n201') ?></div>
                <div class="dish-price"><?php echo getSidePrice($conn, 'i201') ?></div>
            
                <span class="facts"> <!-- Spans with class facts are for displaying item descriptions -->
                    <?php echo getSideFacts($conn, 'n201') ?>
                </span>
            </div>
            
            <div class="dish-item item" onclick="showHiddenDiv('vegDiv')">
                <div class="dish-img-box">
                    <img src="../../images/mixed-vegetables.jpg" alt="Mixed Vegetables">
                </div>

                <div class="dish-title"><?php echo getSideName($conn, 'i202') ?></div>
                <div class="dish-desc"><?php echo getSideDesc($conn,'n202') ?></div>
                <div class="dish-price"><?php echo getSidePrice($conn, 'i202') ?></div>
            
                <span class="facts"> <!-- Spans with class facts are for displaying item descriptions -->
                    <?php echo getSideFacts($conn, 'n202') ?>
                </span>
            </div>
            
            <div class="dish-item item" onclick="showHiddenDiv('mashDiv')">
                <div class="dish-img-box">
                    <img src="../../images/mashed-potatoes.jpg" alt="Mashed Potatoes">
                </div>

                <div class="dish-title"><?php echo getSideName($conn, 'i203') ?></div>
                <div class="dish-desc"><?php echo getSideDesc($conn,'n203') ?></div>
                <div class="dish-price"><?php echo getSidePrice($conn, 'i203') ?></div>
            
                <span class="facts"> <!-- Spans with class facts are for displaying item descriptions -->
                    <?php echo getSideFacts($conn, 'n203') ?>
                </span>
            </div>
            
            <div class="dish-item">
                <div class="dish-img-box">
                    <img src="../../images/fries.jpg" alt="Fries">
                </div>

                <div class="dish-title">FRIES</div>
                <div class="dish-desc">1 small bucket of tasty fries</div>
                <div class="dish-price">PHP 45.00</div>
            </div>
    </div>

    <!-- Contents of the hidden div for Rice -->
    <div id="riceDiv" class="hidden-div">
        
        <h2><?php echo getSideName($conn, 'i201') ?></h2>
        <img src="../../images/rice.jpg" alt="Steamed Rice" style="width: 10%; height: 10%;"> <br>
        <div class="counter"> <!-- Counter for selecting the quantity of rice -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="item" value="rice"> <!-- Hidden value to indicate that rice was the selected item-->
                <input type="number" id="count" name="count" value="1" min="1" max="<?php echo $maxs01Stock; ?>"> <br>
                <input type="submit" value ="Submit" name="submit"> <!-- Submit button for finalizing order -->
            </form>
        </div>
    </div>

    <!-- Contents of the hidden div for Mixed Vegetables -->
    <div id="vegDiv" class="hidden-div">
        
        <h2><?php echo getSideName($conn, 'i202') ?></h2>
        <img src="../../images/mixed-vegetables.jpg" alt="Mixed Vegetables" style="width: 10%; height: 10%;"> <br>
        <div class="counter"> <!-- Counter for selecting the quantity of veg -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="item" value="veg"> <!-- Hidden value to indicate that veg was the selected item-->
                <input type="number" id="count" name="count" value="1" min="1" max="<?php echo $maxs02Stock; ?>"> <br>
                <input type="submit" value ="Submit" name="submit"> <!-- Submit button for finalizing order -->
            </form>
        </div>
    </div>

    <!-- Contents of the hidden div for Mashed Potatoes -->
    <div id="mashDiv" class="hidden-div">
        
        <h2><?php echo getSideName($conn, 'i203') ?></h2>
        <img src="../../images/mashed-potatoes.jpg" alt="Mixed Vegetables" style="width: 10%; height: 10%;"> <br>
        <div class="counter"> <!-- Counter for selecting the quantity of mash -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="item" value="mash"> <!-- Hidden value to indicate that mash was the selected item-->
                <input type="number" id="count" name="count" value="1" min="1" max="<?php echo $maxs03Stock; ?>"> <br>
                <input type="submit" value ="Submit" name="submit"> <!-- Submit button for finalizing order -->
            </form>
        </div>
    </div>

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

        function sideStocks($conn) {

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
