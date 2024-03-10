<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drinks</title>
    <style>
body {
            margin: 0;
            padding: 0;
            background-image: url('menubg.png'); 
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
        }
    </style>
</head>
<body>
    <nav>
    <a href="mains.php">Main</a>
        <a href="sides.php" >Sides</a>
        <a href="drink.php" class="current-page">Drinks</a>
        <a href="cart.php">Cart</a>
        <a href="mainmenu.php">Back to Hub</a>
    </nav>
    <main>
        <h1>Drinks</h1>
        <ul>
            <li>
            <img src="../images/water.png" alt="Water">      
            Water
            </li>
            <li>
            <img src="../images/coffee.png" alt="Coffee">      
            Coffee
            </li>
            <li>
            <img src="../images/oj.png" alt="Orange Juice">    
            Orange Juice
            </li>
            <!-- Add more main dishes as needed -->
        </ul>
    </main>
</body>
</html>
