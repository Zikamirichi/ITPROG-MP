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
            background-color: white;
            padding: 20px;
            padding-bottom: 30px;
            border: 1px solid black;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        

        h2 {
            padding: 25px;
            margin: 0;
            margin-bottom: 20px;
            max-width: 525px;
            background-color: #D4471F;
            font-family: "Luckiest Guy", cursive;
            font-weight: 400;
            font-style: normal;
            font-size: 40px;
            color: white;
        }

        /* CSS styles for the quantity modifier box */
        .counter {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%; 
        }

        .counter input[type="number"] {
            width: 90px; 
            height:30px;
            font-size: 25px;
            text-align: center;
            margin-bottom: 10px; 
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
        echo "<div id='$drinkID' class='hidden-div'>";
            echo "<h2>$name</h2>";

            // Limit style to 10%, may edit later
            echo "<img src='../../images/$imageName' alt='" . $name . "' style='width: 300px; height: 200px; object-fit: cover;'>";
        
            echo "<div class='counter'>";
                echo "<form method='post'>";
                    echo "<input type='hidden' name='item' value='$drinkID'>";
                    echo "<input type='number' name='count' value='1' min='1' max='$maxStock'>";
                    echo "<div>"; // Start a div to contain both buttons
                        echo "<button type='button' class='cancel-button' onclick=\"hideHiddenDiv('$drinkID')\">Cancel</button>"; // Cancel button
                        echo "<button type='submit' class='submit-button' name='submit'>Submit</button>"; // Submit button
                    echo "</div>"; // End of button div
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

    // Function to hide the hidden div based on the provided div ID
    function hideHiddenDiv(divId) {
        var divToHide = document.getElementById(divId);
        divToHide.style.display = "none";
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
