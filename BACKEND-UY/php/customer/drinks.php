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

        .hidden-div {
            display: none;
            position: absolute;
            length: 50%;
            width: 30%; /* updated width */
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: lightgrey;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            padding: 25px;
            margin: 0;
            margin-bottom: 30px;
            background-color: #D4471F;
            font-family: "Luckiest Guy", cursive;
            font-weight: 400;
            font-style: normal;
            font-size: 50px;
            color: white;
        }

        /*CSS for prompts */
        .card-container { 
            width: 634.7px; 
            height: 453.2px; 
            border-radius: 10px; 
            overflow: hidden; 
            font-family: 'Luckiest Guy', cursive; 
            text-transform: uppercase; 
            background-color: white; 
        } 

        .header { 
            height: 72.4px; 
            background-color: #FF5733; 
            color: white; 
            font-size: 24.4px; 
            text-align: center; 
            line-height: 72.4px; 
        } 

        .close-button { 
            position: absolute; 
            top: 50%; 
            right: 20px; 
            transform: translateY(-50%); 
            cursor: pointer; 
        } 

        .close-icon { 
            width: 44px; 
            height: 43.9px; 
            border-radius: 50%; 
            border: 2px solid white; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            font-size: 24px; 
            background: transparent; 
        } 

        .body { 
            padding: 20px; 
        } 

        .image { 
            width: 287.3px;
             height: 191.4px; 
             display: block; 
             margin: 0 auto; 
            } 
        .quantity-container { 
            width: 165.2px; 
            height: 51.8px; 
            margin: 20px auto; 
            text-align: center; 
        } 

        .quantity-text { 
            font-size: 23px; 
        } 

        .quantity-input { 
            font-size: 23px; 
            width: 100px; 
        } 
        .buttons-container { 
            display: flex; 
            justify-content: center; 
            margin-top: 20px; 
        } 
        button { 
            width: 269.8px; 
            height: 61.1px; 
            font-size: 24.4px; 
            cursor: pointer; 
            border: none; 
            border-radius: 30px; 
            text-transform: uppercase; 
            font-family: 'Luckiest Guy', cursive; 
            margin: 0 10px; 
        } 
        .cancel-button { 
            background-color: black; 
            color: white; 
        } 

        .confirm-button { 
            background-color: #FF5733; 
            color: white; 
        } 

        .hidden-div {
            background-color: transparent;  
            padding: 0; margin: 0; 
            border: none; 
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
            <li><a href="processOrders.php">
                <div class="navbar-icon">
                    <img src="../../images/white-cart-button.png" alt="Cart">
                </div>
            </a></li>
        </ul>
    </div>

    <div class="right-container">
        <div class="select-text">DRINKS</div>
            
            <div class="dish-main-box">
                <?php
                    $drinksQuery = mysqli_query($conn, "SELECT * FROM drinks"); // Fetch all drinks dishes
                    while ($drinkItem = mysqli_fetch_assoc($drinksQuery)) { // Iterate over each drinks
                ?>
                <div class="dish-item item" onclick="showHiddenDiv('<?php echo $drinkItem['drinks_id']; ?>')"> <!-- Onclick for hidden div -->
                    <div class="dish-img-box">
                        <?php
                            echo "<img src='../../images/" . $drinkItem['image_name'] . "' alt='" . $drinkItem['names'] . "'>";
                        ?>
                    </div>

                    <div class="dish-title"><?php echo $drinkItem['names']; ?></div>
                    <div class="dish-desc"><?php echo getDrinkDesc($conn, $drinkItem['nutr_facts_id']); ?></div>
                    <div class="dish-price"><?php echo "PHP " . $drinkItem['price'] . ".00"; ?></div>

                    <span class="facts">
                        <?php echo getDrinkFacts($conn, $drinkItem['nutr_facts_id']); ?>
                    </span>
                </div>
                <?php
                    }?>
            </div>
        </div>
    </div>

    <?php
        // Loop through all drinks in the table
        $drinksResult = mysqli_query($conn, "SELECT * FROM drinks"); // Fetch all drinks
        while ($row = mysqli_fetch_assoc($drinksResult)) {

            $drinkID = $row['drinks_id'];
            $name = $row['names'];
            $stockID = $row['stocks_id'];
            $imageName = $row['image_name'];
        
            // Get max stock
            $stockQuery = "SELECT quantity FROM stocks WHERE stocks_id='$stockID'";
            $stockResult = mysqli_query($conn, $stockQuery);
            $stockRow = mysqli_fetch_assoc($stockResult);
            $maxStock = $stockRow['quantity'];
        
            // Hidden div
            echo "<form method='post'>";
            echo "<div id='$drinkID' class='hidden-div'>"; 
            echo "<div class='card-container'>"; 
            echo "<div class='header'>"; 
            echo "<div class='header-text'>$name</div>"; 
            echo "<div class='close-button'>"; 
            echo "<div class='circle'></div>"; 
            echo "<div class='circle'></div>"; 
            echo "<div class='close-icon'>X</div>"; 
            echo "</div>"; 
            echo "</div>"; 
            echo "<div class='body'>"; 
            echo "<img src='../../images/$imageName' alt='$name' class='image'>"; 
            echo "<div class='quantity-container'>"; 
            echo "<div class='quantity-text'>Quantity:</div>"; 
            echo "<input type='number' name='count' value='1' min='1' max='$maxStock' class='quantity-input'>"; 
            echo "</div>"; 
            echo "<div class='buttons-container'>"; 
            echo "<button type='button' class='cancel-button' onclick='cancelPrompt(\"$drinkID\")'>CANCEL</button>";
            echo "<input type='hidden' name='item' value='$drinkID'>"; 
            echo "<button type='submit' name='submit' class='confirm-button'>CONFIRM</button>"; 
            echo "</div>"; 
            echo "</div>"; 
            echo "</div>"; 
            echo "</div>";
            echo "</form>"; 
        
        }
  ?>
    <script>
    function cancelPrompt(drinkID) {
        var hiddenDiv = document.getElementById(drinkID);
        hiddenDiv.style.display = 'none'; 
        document.getElementById('form-' + drinkID).reset(); 
    }
   </script>

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
        if(!isset($_SESSION['drinks'])) { // Checks if a drinks array has already been set (to avoid reset everytime drinks.php is visited in current session)
            
            $_SESSION['drinks'] = []; // Set an array to store all drinks orders in SESSION
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
            
                $drinkID = $_POST["item"]; // Get $drinkID
            
                $order = new Order($orderID); 
                $order->setOrder($count, $drinkID); // Set new order
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
