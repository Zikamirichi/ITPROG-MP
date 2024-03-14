<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/ITPROG-MP/BACKEND-UY/css/navbar.css" />
    <link rel="stylesheet" type="text/css" href="/ITPROG-MP/BACKEND-UY/css/dish.css" />
  </head>
    <title>Cart</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('/ITPROG-MP/BACKEND-UY/images/menubg.png'); 
            background-size: cover;
            background-position: center;
            display: flex;
        }

        .cart-main-box {
            background-color: #CED3D7;
            margin-left: 5%;
            margin-right: 5%;
            border-radius: 15px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .cart-item-box {
            margin: 2%;
            border-radius: 15px;
            background-color: white;
            font-family: "Luckiest Guy", cursive;
            font-weight: 400;
            font-style: normal;
            font-size: 23px;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
            position: relative;
        }

        /* TO DO:
        - Divide cart-item-box into 3 parts (dish title, quantity, price)
        - design for combo meal title
        - create for total
        - create - and + for quantity
        - create confirm and cancel buttons
        - integrate with prompt messages */
    </style>
</head>
<body>
<div class="navigation-bar">
        <ul>
            <li><a href="homepage.php">
                    <div class="navbar-icon">
                        <img src="/ITPROG-MP/BACKEND-UY/images/white-home-button.png" alt="Homepage">
                    </div>
                </a></li>
            <li><a href="mains.php">
                <div class="navbar-icon">
                    <img src="/ITPROG-MP/BACKEND-UY/images/white-main-button.png" alt="Main Dishes">
                </div>
            </a></li>

            <li><a href="sides.php">
                <div class="navbar-icon">
                    <img src="/ITPROG-MP/BACKEND-UY/images/white-side-button.png" alt="Side Dishes">
                </div>
            </a></li>
            <li><a href="drinks.php">
                <div class="navbar-icon">
                    <img src="/ITPROG-MP/BACKEND-UY/images/white-drink-button.png" alt="Drinks">
                </div>
            </a></li>
            <li><a href="cart.php" class="active">
                <div class="navbar-icon">
                    <img src="/ITPROG-MP/BACKEND-UY/images/white-cart-button.png" alt="Cart">
                </div>
            </a></li>
        </ul>
    </div>

    <div class="right-container">
        <div class="select-text">CART</div>
        <div class="cart-main-box">
            <div class="cart-item-box">
                ROASTED CHICKEN
            </div>
            <div class="cart-item-box">
                RICE
            </div>
            <div class="cart-item-box">
                ORANGE JUICE
            </div>
        </div>
    </div>
</body>
</html>
