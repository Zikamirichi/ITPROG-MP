<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/navbar.css" />
    <link rel="stylesheet" type="text/css" href="../css/dish.css" />
    <title>Side Dishes</title>
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

            <li><a href="sides.php" class="active">
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
        <div class="select-text">SIDE DISHES</div>
        <div class="dish-main-box">
            <div class="dish-item">
                <div class="dish-img-box">
                    <img src="../images/rice.jpg" alt="Roasted Chicken">
                </div>

                <div class="dish-title">RICE</div>
                <div class="dish-desc">1 cup of white rice</div>
                <div class="dish-price">PHP 20.00</div>
            </div>
            <div class="dish-item">
                <div class="dish-img-box">
                    <img src="../images/mixed-vegetables.jpg" alt="Ceasar Salad">
                </div>

                <div class="dish-title">MIXED VEGETABLES</div>
                <div class="dish-desc">1 bowl of nutrituous vegetables</div>
                <div class="dish-price">PHP 30.00</div>
            </div>
            <div class="dish-item">
                <div class="dish-img-box">
                    <img src="../images/mashed-potatoes.jpg" alt="Ceasar Salad">
                </div>

                <div class="dish-title">MASHED POTATOES</div>
                <div class="dish-desc">1 creamy bowl of potatoes</div>
                <div class="dish-price">PHP 30.00</div>
            </div>
            <div class="dish-item">
                <div class="dish-img-box">
                    <img src="../images/fries.jpg" alt="Fries">
                </div>

                <div class="dish-title">FRIES</div>
                <div class="dish-desc">1 small bucket of tasty fries</div>
                <div class="dish-price">PHP 45.00</div>
            </div>

    </div>
</body>
</html>
