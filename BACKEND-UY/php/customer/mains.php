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

        $_SESSION['cart_refreshed'] = false; // For cart purposes

    ?>
    <div class="navigation-bar">
        <ul>
            <li><a href="cancelOrder.php">
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
            <li><a href="processOrders.php">
                <div class="navbar-icon">
                    <img src="../../images/white-cart-button.png" alt="Cart">
                </div>
            </a></li>
        </ul>
    </div>

    <div class="right-container">
        <div class="select-text">MAIN DISHES</div>
            
            <div class="dish-main-box">
                <?php
                    $mainDishesQuery = mysqli_query($conn, "SELECT * FROM mains"); // Fetch all main dishes
                    while ($mainDish = mysqli_fetch_assoc($mainDishesQuery)) { // Iterate over each main dish
                ?>
                <div class="dish-item item" onclick="showHiddenDiv('<?php echo $mainDish['mains_id']; ?>')"> <!-- Onclick for hidden div -->
                    <div class="dish-img-box">
                        <?php
                             echo "<img src='../../images/" . $mainDish['image_name'] . "' alt='" . $mainDish['name'] . "'>";
                        ?>
                    </div>

                    <div class="dish-title"><?php echo $mainDish['name']; ?></div>
                    <div class="dish-desc"><?php echo getMainDesc($conn, $mainDish['nutr_facts_id']); ?></div>
                    <div class="dish-price"><?php echo "PHP " . $mainDish['price'] . ".00"; ?></div>

                    <span class="facts">
                        <?php echo getMainFacts($conn, $mainDish['nutr_facts_id']); ?>
                    </span>
                </div>
                <?php
                    }?>
            </div>
        </div>
    </div>

    <?php
        // Loop through all mains in the table
        $mainsResult = mysqli_query($conn, "SELECT * FROM mains"); // Fetch all main dishes
        while ($row = mysqli_fetch_assoc($mainsResult)) {

            $mainID = $row['mains_id'];
            $name = $row['name'];
            $stockID = $row['stocks_id'];
            $imageName = $row['image_name'];
        
            // Get max stock
            $stockQuery = "SELECT quantity FROM stocks WHERE stocks_id='$stockID'";
            $stockResult = mysqli_query($conn, $stockQuery);
            $stockRow = mysqli_fetch_assoc($stockResult);
            $maxStock = $stockRow['quantity'];
        
            // Hidden div
            echo "<div id='$mainID' class='hidden-div'>";
                echo "<h2>$name</h2>";
                
                // Limit style to 10%, may edit later
                echo "<img src='../../images/$imageName' alt='" . $name . "' style='width: 10%; height: 10%;'>";
            
                echo "<div class='counter'>";
                    echo "<form method='post'>";
                        echo "<input type='hidden' name='item' value='$mainID'>";
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
        if (divToShow.style.display === "none" || divToShow.style.display === "") {
            
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
            
            if(isset($_POST["count"])) {

                $count = $_POST["count"];
            
                // Get max order ID
                $maxOrderQuery = "SELECT MAX(CAST(SUBSTRING(ordr_id, 2) AS UNSIGNED)) AS max_orderID FROM order_table";
                $maxResult = mysqli_query($conn, $maxOrderQuery);
                $maxRow = mysqli_fetch_assoc($maxResult);
                $maxOrderID = $maxRow['max_orderID'];
            
                $orderID = "o" . ($maxOrderID + 1);
            
                $mainID = $_POST["item"]; // Get $mainID
            
                $order = new Order($orderID); 
                $order->setOrder($count, $mainID); // Set new order
            
                // Output for testing REMOVE LATER
                echo "Order ID: " . $order->getOrderID() . "<br>";
                echo "Quantity: " . $order->getQuantity() . "<br>";
                echo "Item ID: " . $mainID . "<br>";
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
