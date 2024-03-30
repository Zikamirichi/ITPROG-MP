<!-- Reference: https://codepen.io/juliankern/pen/xpWqZw -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../css/navbar.css" />
    <link rel="stylesheet" type="text/css" href="../../css/dish.css" />
    <title>Main Dishes</title>
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

        mainStocks($conn);
    ?>
    <div class="navigation-bar">
        <ul>
            <li><a href="homepage.php">
                    <div class="navbar-icon">
                        <img src="../../images/white-home-button.png" alt="Homepage">
                    </div>
                </a></li>
            <li><a href="mains.php" class="active">
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
            <li><a href="cart.php">
                <div class="navbar-icon">
                    <img src="../../images/white-cart-button.png" alt="Cart">
                </div>
            </a></li>
        </ul>
    </div>

    <div class="right-container">
        <div class="select-text">MAIN DISHES</div>
        <div class="dish-main-box">
            
            <div class="dish-item item" onclick="showHiddenDiv('chickenDiv')">
                
                <div class="dish-img-box">
                    <img src="../../images/roasted-chicken.jpg" alt="Roasted Chicken">
                </div>

                <div class="dish-title"><?php echo getMainName($conn, 'i101') ?></div>
                <div class="dish-desc"><?php echo getMainDesc($conn,'n101') ?></div>
                <div class="dish-price"><?php echo getMainPrice($conn, 'i101') ?></div>

                <span class="facts"> <!-- Spans with class facts are for displaying item descriptions -->
                    <?php echo getMainFacts($conn, 'n101') ?>
                </span>
            </div>
            
            <div class="dish-item item" onclick="showHiddenDiv('saladDiv')">
                <div class="dish-img-box">
                    <img src="../../images/ceasar-salad.jpg" alt="Ceasar Salad">
                </div>

                <div class="dish-title"><?php echo getMainName($conn, 'i102') ?></div>
                <div class="dish-desc"><?php echo getMainDesc($conn,'n102') ?></div>
                <div class="dish-price"><?php echo getMainPrice($conn, 'i102') ?></div>

                <span class="facts"> <!-- Spans with class facts are for displaying item descriptions -->
                    <?php echo getMainFacts($conn, 'n102') ?>
                </span>
            </div>
            <div class="dish-item">
                <div class="dish-img-box">
                    <img src="../../images/burger.jpg" alt="Burger">
                </div>

                <div class="dish-title">BURGER</div>
                <div class="dish-desc">1 juicy beef burger</div>
                <div class="dish-price">PHP 70.00</div>
            </div>
        </div>
    </div>

    <!-- Contents of the hidden div for chicken -->
    <div id="chickenDiv" class="hidden-div">
        
        <h2><?php echo getMainName($conn, 'i101') ?></h2>
        <img src="../../images/roasted-chicken.jpg" alt="Roasted Chicken" style="width: 10%; height: 10%;"> <br>
        <div class="counter"> <!-- Counter for selecting the quantity of chicken -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="item" value="chicken"> <!-- Hidden value to indicate that chicken was the selected item-->
                <input type="number" id="count" name="count" value="1" min="1" max="<?php echo $maxm01Stock; ?>"> <br>
                <input type="submit" value ="Submit" name="submit"> <!-- Submit button for finalizing order -->
            </form>
        </div>
    </div>

    <!-- Contents of the hidden div for Salad -->
    <div id="saladDiv" class="hidden-div">
        
        <h2><?php echo getMainName($conn, 'i102') ?></h2>
        <img src="../../images/ceasar-salad.jpg" alt="Caesar Salad" style="width: 10%; height: 10%;"> <br>
        <div class="counter"> <!-- Counter for selecting the quantity of salad -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="item" value="salad"> <!-- Hidden value to indicate that salad was the selected item -->
                <input type="number" id="count" name="count" value="1" min="1" max="<?php echo $maxm02Stock; ?>"> <br>
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
        if(!isset($_SESSION['mains'])) { // Checks if a mains array has already been set (to avoid reset everytime mains.php is visited in current session)
                    
            $_SESSION['mains'] = []; // Set an array to store all mains orders in SESSION
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

                if ($item == "chicken") { 
                    
                    $order->setOrder($count, "i101"); // If submit button pressed was under Roasted Chicken, set itemID to i101
                }
                
                if ($item == "salad") {
                    
                    $order->setOrder($count, "i102"); // Salad = i102
                }

                // TESTING; REMOVE ECHOES IN FINAL PROJECT
                echo "Order ID: " . $order->getOrderID() . "<br>"; 
                echo "Quantity: " . $order->getQuantity() . "<br>";
                echo "Item ID: " . $order->getItemID() . "<br>";
            }
            
            
            if(isset($_POST["submit"])) { // Check if the submit button was pressed
                $ordr_id = $order->getOrderID(); // Getters for data to be inserted in database
                $quantity = $order->getQuantity();
                $item_id = $order->getItemID();
            
                error_reporting(E_ERROR | E_PARSE);
                
                // Insert values into orders table
                $insert = "INSERT INTO order_table VALUES ('$ordr_id', '$quantity', '$item_id')";
                mysqli_query($conn, $insert);

                // Update stocks table based on item ID with order quantity
                $updateMainsStock = "UPDATE stocks s
                                        JOIN mains m ON s.stocks_id = m.stocks_id
                                        SET s.quantity = s.quantity - $quantity
                                        WHERE m.mains_id = '$item_id'";
                mysqli_query($conn, $updateMainsStock); 

                array_push($_SESSION['mains'],$ordr_id); // Add order IDs to mains array in session

                echo "Record has been successfully inserted!"; // TESTING ALSO, CAN REMOVE along with else statement
                
                } else {
                    echo "Failed to insert record!!!";
                }
        }
        function mainStocks($conn) {

            // Get stocks from database for input to be limited to the available stocks
            $maxm01StockQuery = "SELECT quantity FROM stocks WHERE stocks_id = 'm01';";
            $maxm01StockResult = mysqli_query($conn, $maxm01StockQuery);
            $maxm01StockRow = mysqli_fetch_assoc($maxm01StockResult);
            $maxm01Stock = $maxm01StockRow['quantity'];

            $maxm02StockQuery = "SELECT quantity FROM stocks WHERE stocks_id ='m02';";
            $maxm02StockResult = mysqli_query($conn, $maxm02StockQuery);
            $maxm02StockRow = mysqli_fetch_assoc($maxm02StockResult);
            $maxm02Stock = $maxm02StockRow['quantity'];
        }

        function getMainDesc($conn, $ntrID) {

            $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id = '$ntrID'"); // Displays nutrition facts of roasted chicken with id n101
            
            $factsResult = mysqli_fetch_assoc($factsQuery);

            return $factsResult['desc'];
        }

        function getMainName($conn, $mainID) {

            $nameQuery = mysqli_query($conn, "SELECT name FROM mains WHERE mains_id = '$mainID'");

            $nameResult = mysqli_fetch_assoc($nameQuery);

            return $nameResult['name'];
        }

        function getMainPrice($conn, $mainID) {

            $priceQuery = mysqli_query($conn, "SELECT price FROM mains WHERE mains_id = '$mainID'");

            $priceResult = mysqli_fetch_assoc($priceQuery);

            return "PHP " . $priceResult['price'] . ".00";
        }

        function getMainFacts($conn, $ntrID) {

            $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id = '$ntrID'"); // Displays nutrition facts of roasted chicken with id n101
            
            while ($factsResult = mysqli_fetch_assoc($factsQuery)) {
                
                echo '<div class="dish-desc">';
                echo "<strong>Nutrition Facts:</strong> <br>";
                echo "Calories: ". $factsResult ["Calories"], "g<br>";
                echo "Fat: ". $factsResult ["Fat"], "g<br>";
                echo "Carbs: ". $factsResult ["Carbs"], "g<br>";
                echo "Protein: ". $factsResult ["Protein"], "g<br>";

                echo '<br>';
                echo "Ingredients: <br>". $factsResult ["Ingredients"], "<br><br>";
                echo '</div>';
            }
        }
    ?>
</body>
</html>
