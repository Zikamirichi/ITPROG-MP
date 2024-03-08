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
        $conn = mysqli_connect("localhost", "root", "12345", "mydb", "3360") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");

        session_start();
        require_once("item.php"); 

        
        $saladObj = new Item(102, 1);
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
                <input type="checkbox" id="chicken" hidden>
                <label for="chicken" class="main">
                    <img src="images/chicken.png" alt="Roasted Chicken"><br>
                    Roasted Chicken (1pc)
                </label>

                <span class="facts">Roasted Chicken Seasoned with Salt and Pepper. <br>
                        Nutrition Facts: <br>
                        Calories: 81 <br>
                        Fat: 53% <br>
                        Carbs: 0% <br>
                        Protein: 47% <br> <br>
                        Ingredients: <br>
                        Chicken, Pepper, Salt</span>
                
                <div class="chicken content">
                    <h2>Roasted Chicken</h2>
                    <img src="images/chicken.png" alt="Roasted Chicken"> <br>
                    <div class="counter">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="number" id="chickenCount" name="chickenCount" value="0"> <br>
                            <input type="submit" value ="Submit" name="submit">
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
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            if(isset($_POST["chickenCount"])){ // Check if the count value is set
                // Retrieve the count value from the POST data
                $count = $_POST["chickenCount"];
                $item = new Item(101, $count);
                $_SESSION['item'] = $item; // Store in session superglobal for use in cart.php
                
                echo "Item ID: " . $item->getID() . "<br>"; // TESTING
                echo "Quantity: " . $item->getQuantity() . "<br>";
                echo "Category: " . $item->getCategory() . "<br>";
            }
            
            if(isset($_POST["submit"])) {
                $ala_id = $_POST["a04"];
                $main_id = $_POST[$item->getID()];
                $quantity = $_POST[$item->getQuantity()];
            
                error_reporting(E_ERROR | E_PARSE);
                
                $insert = "INSERT INTO ala_carte VALUES ('$ala_id', '$main_id', '$quantity', NULL, 0, NULL, 0)";
                mysqli_query($conn, $insert);
                echo "Record has been successfully inserted!";
                
                } else {
                    echo "Failed to insert record!!!";
                }
            
        }
?>

</body>
</html>
