<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu</title>
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

        main {
            flex: 1;
            padding: 20px;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            align-content: stretch;
            flex-wrap: wrap;
            justify-content: space-evenly;
        }

        main h1 {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        main img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            cursor: pointer;
        }

        .images-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            flex-wrap: wrap;
            align-items: center;
        }

        .cart-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
            flex-wrap: wrap;
            align-items: center;
        }

        .cart-button {
            display: inline-block;
            bottom: 100px;
            right: 200px;
            padding: 25px 35px;
            background-color: black;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: auto;
            cursor: pointer;
        }

        .cart-button:hover {
            background-color: grey;
        }
    </style>
</head>
<body>
    <nav>
    </nav>
    <main>
        <h1>Select the Dish you wish to order</h1>
        <div class="images-container">
            <a href="mains.php"><img src="../images/main.png" alt="Main"></a>
            <a href="sides.php"><img src="../images/side.png" alt="Side"></a>
            <a href="drink.php"><img src="../images/drinks.png" alt="Drinks"></a>
        </div>

        <div class="cart-container">
            <a href="cart.php" class="cart-button">Go to Cart</a>
            <a href="start.php" class="cart-button">Go Back</a>
        </div>
    </main>
</body>
</html>
