<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="navbar.css" />
    <title>Main Dishes</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('menubg.png'); 
            background-size: cover;
            background-position: center;
            display: flex;
        }
    </style>
</head>
<body>
    <div class="navigation-bar">
        <ul>
            <li><a href="homepage.php">
                    <div class="navbar-icon">
                        <img src="../images/white-home-button.png" alt="Homepage">
                    </div>
                </a></li>
            <li><a href="mains.php" class="active">
                <div class="navbar-icon">
                    <img src="../images/white-main-button.png" alt="Main Dishes">
                </div>
            </a></li>

            <li><a href="sides.php">
                <div class="navbar-icon">
                    <img src="../images/white-side-button.png" alt="Side Dishes">
                </div>
            </a></li>
            <li><a href="drinks.php">
                <div class="navbar-icon">
                    <img src="../images/white-drink-button.png" alt="Drinks">
                </div>
            </a></li>
            <li><a href="cart.php">
                <div class="navbar-icon">
                    <img src="../images/white-cart-button.png" alt="Cart">
                </div>
            </a></li>
        </ul>
    </div>

    <div class="right-container">
        <div class="select-text">MAIN DISHES</div>
    </div>
</body>
</html>
