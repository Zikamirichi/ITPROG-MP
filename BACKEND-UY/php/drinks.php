<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/navbar.css" />
    <link rel="stylesheet" type="text/css" href="../css/dish.css" />
    <title>Drinks</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('../images/menubg.png'); 
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
            <li><a href="mains.php">
                <div class="navbar-icon">
                    <img src="../images/white-main-button.png" alt="Main Dishes">
                </div>
            </a></li>

            <li><a href="sides.php">
                <div class="navbar-icon">
                    <img src="../images/white-side-button.png" alt="Side Dishes">
                </div>
            </a></li>
            <li><a href="drinks.php" class="active">
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
        <div class="select-text">DRINKS</div>
        <div class="dish-main-box">
            <div class="dish-item">
                <div class="dish-img-box">
                    <img src="../images/bottled-water.jpg" alt="Bottled Water">
                </div>

                <div class="dish-title">BOTTLED WATER</div>
                <div class="dish-desc">1 cold purified water</div>
                <div class="dish-price">PHP 20.00</div>
            </div>
            <div class="dish-item">
                <div class="dish-img-box">
                    <img src="../images/black-coffee.jpg" alt="Black Coffee">
                </div>

                <div class="dish-title">BLACK COFFEE</div>
                <div class="dish-desc">1 cup of hot aromatic coffee</div>
                <div class="dish-price">PHP 50.00</div>
            </div>
            <div class="dish-item">
                <div class="dish-img-box">
                    <img src="../images/orange-juice.jpg" alt="Orange Juice">
                </div>

                <div class="dish-title">ORANGE JUICE</div>
                <div class="dish-desc">1 glass of refreshing orange</div>
                <div class="dish-price">PHP 30.00</div>
            </div>

    </div>
</body>
</html>
