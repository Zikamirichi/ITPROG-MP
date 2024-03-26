<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/navbar.css" />
    <link rel="stylesheet" type="text/css" href="../../css/dish.css" />
    <title>Drinks</title>
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

        drinkStocks($conn);
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
            <li><a href="drinks.php" class="active">
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
        <div class="select-text">DRINKS</div>
        <div class="dish-main-box">
            
            <div class="dish-item item" onclick="showHiddenDiv('waterDiv')">
                <div class="dish-img-box">
                    <img src="../../images/bottled-water.jpg" alt="Bottled Water">
                </div>

                <div class="dish-title"><?php echo getDrinkName($conn, 'i301') ?></div>
                <div class="dish-desc"><?php echo getDrinkDesc($conn,'n301') ?></div>
                <div class="dish-price"><?php echo getDrinkPrice($conn, 'i301') ?></div>
            </div>

            <div class="dish-item item" onclick="showHiddenDiv('coffeeDiv')">
                <div class="dish-img-box">
                    <img src="../../images/black-coffee.jpg" alt="Black Coffee">
                </div>

                <div class="dish-title"><?php echo getDrinkName($conn, 'i302') ?></div>
                <div class="dish-desc"><?php echo getDrinkDesc($conn,'n302') ?></div>
                <div class="dish-price"><?php echo getDrinkPrice($conn, 'i302') ?></div>
            </div>

            <div class="dish-item item" onclick="showHiddenDiv('ojDiv')">
                <div class="dish-img-box">
                    <img src="../../images/orange-juice.jpg" alt="Orange Juice">
                </div>

                <div class="dish-title"><?php echo getDrinkName($conn, 'i303') ?></div>
                <div class="dish-desc"><?php echo getDrinkDesc($conn,'n303') ?></div>
                <div class="dish-price"><?php echo getDrinkPrice($conn, 'i303') ?></div>
            </div>
    </div>

    <!-- Contents of the hidden div for Water -->
    <div id="waterDiv" class="hidden-div">
        
        <h2><?php echo getDrinkName($conn, 'i301') ?></h2>
        <img src="../../images/bottled-water.jpg" alt="Bottled Water" style="width: 10%; height: 10%;"> <br>
        <div class="counter"> <!-- Counter for selecting the quantity of water -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="item" value="water"> <!-- Hidden value to indicate that water was the selected item-->
                <input type="number" id="count" name="count" value="1" min="1" max="<?php echo $maxd01Stock; ?>"> <br>
                <input type="submit" value ="Submit" name="submit"> <!-- Submit button for finalizing order -->
            </form>
        </div>
    </div>

    <!-- Contents of the hidden div for Water -->
    <div id="coffeeDiv" class="hidden-div">
        
        <h2><?php echo getDrinkName($conn, 'i302') ?></h2>
        <img src="../../images/black-coffee.jpg" alt="Black Coffee" style="width: 10%; height: 10%;"> <br>
        <div class="counter"> <!-- Counter for selecting the quantity of coffee -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="item" value="coffee"> <!-- Hidden value to indicate that water was the selected item-->
                <input type="number" id="count" name="count" value="1" min="1" max="<?php echo $maxd02Stock; ?>"> <br>
                <input type="submit" value ="Submit" name="submit"> <!-- Submit button for finalizing order -->
            </form>
        </div>
    </div>

    <!-- Contents of the hidden div for Orange Juice -->
    <div id="ojDiv" class="hidden-div">
        
        <h2><?php echo getDrinkName($conn, 'i303') ?></h2>
        <img src="../../images/orange-juice.jpg" alt="Orange Juice" style="width: 10%; height: 10%;"> <br>
        <div class="counter"> <!-- Counter for selecting the quantity of orange juice -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="item" value="oj"> <!-- Hidden value to indicate that orange juice was the selected item-->
                <input type="number" id="count" name="count" value="1" min="1" max="<?php echo $maxd03Stock; ?>"> <br>
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
        if(!isset($_SESSION['drinks'])) { // Checks if a drinks array has already been set (to avoid reset everytime drinks.php is visited in current session)
            
            $_SESSION['drinks'] = []; // Set an array to store all drinks orders in SESSION
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

                if ($item == "water") { 
                    
                    $order->setOrder($count, "i301"); // If submit button pressed was under water, set itemID to i301
                }
                
                if ($item == "coffee") {
                    
                    $order->setOrder($count, "i302"); // Coffee = i302
                }

                if ($item == "oj") {
                    
                    $order->setOrder($count, "i303"); // Orange Juice = i303
                }

                // TESTING REMOVE IN FINAL PRODUCT
                echo "Order ID: " . $order->getorderID() . "<br>"; 
                echo "Quantity: " . $order->getQuantity() . "<br>";
                echo "Item ID: " . $order->getItemID() . "<br>";
            }
            
            
            if(isset($_POST["submit"])) {
                $ordr_id = $order->getOrderID();
                $quantity = $order->getQuantity();
                $item_id = $order->getItemID();
            
                error_reporting(E_ERROR | E_PARSE);
                
                $insert = "INSERT INTO order_table VALUES ('$ordr_id', '$quantity', '$item_id')";
                mysqli_query($conn, $insert);

                // Update stocks table based on item ID with order quantity
                $updateDrinkStock = "UPDATE stocks s
                                        JOIN drinks d ON s.stocks_id = d.stocks_id
                                        SET s.quantity = s.quantity - $quantity
                                        WHERE d.drinks_id = '$item_id'";
                mysqli_query($conn, $updateDrinkStock); 

                array_push($_SESSION['drinks'],$ordr_id); // Add order IDs to drinks array in session

                echo "Record has been successfully inserted!";
                
                } else {
                    echo "Failed to insert record!!!";
                }
        }

        function drinkStocks($conn) {

            // Get stocks from database for input to be limited to the available stocks
            $maxd01StockQuery = "SELECT quantity FROM stocks WHERE stocks_id = 'd01';";
            $maxd01StockResult = mysqli_query($conn, $maxd01StockQuery);
            $maxd01StockRow = mysqli_fetch_assoc($maxd01StockResult);
            $maxd01Stock = $maxd01StockRow['quantity'];

            $maxd02StockQuery = "SELECT quantity FROM stocks WHERE stocks_id = 'd02';";
            $maxd02StockResult = mysqli_query($conn, $maxd02StockQuery);
            $maxd02StockRow = mysqli_fetch_assoc($maxd02StockResult);
            $maxd02Stock = $maxd02StockRow['quantity'];

            $maxd03StockQuery = "SELECT quantity FROM stocks WHERE stocks_id = 'd03';";
            $maxd03StockResult = mysqli_query($conn, $maxd03StockQuery);
            $maxd03StockRow = mysqli_fetch_assoc($maxd03StockResult);
            $maxd03Stock = $maxd03StockRow['quantity'];

            /* Comment out since d04 is not used.
            $maxd04StockQuery = "SELECT quantity FROM stocks WHERE stocks_id = 'd04';";
            $maxd04StockResult = mysqli_query($conn, $maxd04StockQuery);
            $maxd04StockRow = mysqli_fetch_assoc($maxd04StockResult);
            $maxd04Stock = $maxd04StockRow['quantity'];
            */
        }

        function getDrinkDesc($conn, $ntrID) {
        
            $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id = '$ntrID'"); // Displays nutrition facts of roasted chicken with id n101
            
            $factsResult = mysqli_fetch_assoc($factsQuery);

            return $factsResult['desc'];
        }

        function getDrinkName($conn, $drinkID) {

            $nameQuery = mysqli_query($conn, "SELECT names FROM drinks WHERE drinks_id = '$drinkID'");

            $nameResult = mysqli_fetch_assoc($nameQuery);

            return $nameResult['names'];
        }

        function getDrinkPrice($conn, $drinkID) {

            $priceQuery = mysqli_query($conn, "SELECT price FROM drinks WHERE drinks_id = '$drinkID'");

            $priceResult = mysqli_fetch_assoc($priceQuery);

            return "PHP " . $priceResult['price'] . ".00";
        }

        function getDrinkFacts($conn, $ntrID) {

            $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id = '$ntrID'"); 
            
            while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
                
                echo "Ingredients: ". $factsResult ["Ingredients"], "g<br><br>";
                echo "Fat: ". $factsResult ["Fat"], "g<br>";
                echo "Calories: ". $factsResult ["Calories"], "g<br>";
                echo "Carbs: ". $factsResult ["Carbs"], "g<br>";
                echo "Protein: ". $factsResult ["Protein"], "g<br>";
            }
        }
    ?>
</body>
</html>
