<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
    <title>Cart</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('menubg.png'); 
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center; /* Center the content horizontally */
            align-items: center; /* Center the content vertically */
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
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            text-align: right
        }

        h1 {
            color: #333;
            text-align: center
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            text-decoration: underline; /* Underline text */
            background-color: white;
            padding: 30px;
            border-radius: 20px; /* Top left, top right, bottom right, bottom left */
        }

        .cart-total {
            background-color: white;
            padding: 30px;
            border-radius: 20px; /* Top left, top right, bottom right, bottom left */
        }

        .cart-item span {
            margin-right: 10px;
        }

        .cart-bg {
            background-color: lightgrey;
            margin: 30px;
            padding: 30px;
            border-radius: 20px; /* Top left, top right, bottom right, bottom left */
        }
    </style>
</head>
<body>
    <nav>
        <a href="mains.php">Main</a>
        <a href="sides.php" >Sides</a>
        <a href="drink.php">Drinks</a>
        <a href="cart.php" class="current-page">Cart</a>
        <a href="mainmenu.php">Back to Hub</a>
    </nav>
    <main>
        <h1>Cart</h1>
        <div class="cart-bg">
        <?php
        // Sample cart data
        $cart = [
            ['item' => 'Roast Chicken (1pc)', 'quantity' => 2, 'price' => 90.00],
            ['item' => 'Rice', 'quantity' => 1, 'price' => 20.00],
            ['item' => 'Orange Juice', 'quantity' => 1, 'price' => 20.00]
        ];
        $total = 0;

        // Display cart items
        echo '<ul>';
        foreach ($cart as $item) {
            $subtotal = $item['quantity'] * $item['price'];
            $total += $subtotal;

            echo '<li class="cart-item">';
            echo '<span><strong>' . $item['item'] . ' x ' . $item['quantity'] . '</strong></span>';
            echo '<span><strong>Php ' . number_format($subtotal, 2) . '</strong></span>';
            echo '</li>';
        }
        echo '</ul>';

        echo '<div class="cart-total">';
        echo '<h3 style="color: lightgrey;">Php' . number_format($total, 2) . '</h3>';

        // Apply discount if there are 3 or more items
        if (count($cart) >= 3) {
            $discount = 0.15 * $total;
            $total -= $discount;
            echo '<p>Discount (15%): -$' . number_format($discount, 2) . '</p>';
        }
        
        // Display total after discount
        echo '<h3>Total: Php' . number_format($total, 2) . '</h3>';
        echo '</div>';
        ?>
        <button>Done</button>
        </div>
        
    </main>
</body>
</html>
