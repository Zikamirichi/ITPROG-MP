<!-- Reference: https://codepen.io/juliankern/pen/xpWqZw -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Dishes</title>
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

        #chicken:checked ~ .chicken,
        #salad:checked ~ .salad { /* Content to be shown */
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

        require_once("order.php"); //Adding the order class for OOP purposes

        $chickenFlag = false; //Flags to determine which submit buttons were pressed
        $saladFlag = false;
    ?>
    <nav>
        <a href="mains.php" class="current-page">Main</a>
        <a href="sides.php">Sides</a>
        <a href="drink.php">Drinks</a>
        <a href="cart.php">Cart</a>
        <a href="mainmenu.php">Back to Hub</a>
    </nav>
    <main>
        <h1>Main Dishes</h1>
        <ul>
            <li class="item">
                <input type="checkbox" id="chicken" hidden> <!-- Hidden checkbox is for bringing out item quantity "mini page". Refer to reference above -->
                <label for="chicken" class="main">
                    <img src="images/chicken.png" alt="Roasted Chicken"><br>
                    Roasted Chicken (1pc)
                </label>

                <span class="facts"> <!-- Spans with class facts are for displaying item descriptions -->
                    <?php
                        $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id = 'n101'"); // Displays nutrition facts of roasted chicken with id n101
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
                
                <div class="chicken content"> <!-- Div for "mini page" for selecting quantity of roasted chicken -->
                    <h2>Roasted Chicken</h2>
                    <img src="images/chicken.png" alt="Roasted Chicken"> <br>
                    <div class="counter"> <!-- Counter for selecting the quantity of chicken -->
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="item" value="chicken"> <!-- Hidden value to indicate that chicken was the selected item, for the flags later on -->
                            <input type="number" id="count" name="count" value="1"> <br>
                            <input type="submit" value ="Submit" name="submit"> <!-- Submit button for finalizing order -->
                        </form>
                </div>
            </li>
            
            <li class="item">
                <input type="checkbox" id="salad" hidden>
                <label for="salad" class="main">
                    <img src="images/salad.png" alt="Caesar Salad"><br>
                    Caesar Salad
                </label>

                <span class="facts">*Insert Description of Caesar Salad*</span>

                <div class="salad content">
                    
                </div>
            </li>
        </ul>
    </main>
    
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") { // When a post is done above, execute code
            
            if(isset($_POST["count"])){ // Check if the count value is set
                
                $count = $_POST["count"]; // Retrieve the count value from the POST data
                
                $maxNutrQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ordr_id, 2) AS UNSIGNED)) AS max_orderID FROM order_table");
                $row = mysqli_fetch_assoc($maxNutrQuery); // Get Current Max order_id from table 
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
                echo "Record has been successfully inserted!";
                
                } else {
                    echo "Failed to insert record!!!";
                }
        }
    ?>

</body>
</html>
