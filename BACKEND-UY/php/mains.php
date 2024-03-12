<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="navbar.css" />
    <link rel="stylesheet" type="text/css" href="dish.css" />
    <title>Main Dishes</title>
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
        <div class="dish-main-box">
            <div class="dish-item">
                <div class="dish-img-box">
                    <img src="../images/roasted-chicken.jpg" alt="Roasted Chicken">
                </div>

                <div class="dish-title">ROASTED CHICKEN</div>
                <div class="dish-desc">1pc quarter leg</div>
                <div class="dish-price">PHP 90.00</div>
            </div>
            <div class="dish-item">
                <div class="dish-img-box">
                    <img src="../images/ceasar-salad.jpg" alt="Ceasar Salad">
                </div>

                <div class="dish-title">CEASAR SALAD</div>
                <div class="dish-desc">1 bowl with chicken cuts</div>
                <div class="dish-price">PHP 90.00</div>
            </div>
            <div class="dish-item">
                <div class="dish-img-box">
                    <img src="../images/burger.jpg" alt="Burger">
                </div>

                <div class="dish-title">BURGER</div>
                <div class="dish-desc">1 juicy beef burger</div>
                <div class="dish-price">PHP 70.00</div>
            </div>

    </div>
</body>
</html>
