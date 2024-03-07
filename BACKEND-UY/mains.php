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

    </style>
</head>
<body>
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
                <img src="images/chicken.png" alt="Roasted Chicken"><br>
                Roasted Chicken (1pc)
                <span class ="facts">Roasted Chicken Seasoned with Salt and Pepper. <br>
                                        Nutrition Facts: <br>
                                        Calories: 81 <br>
                                        Fat: 53% <br>
                                        Carbs: 0% <br>
                                        Protein: 47% <br> <br>
                                        Ingredients: <br>
                                        Chicken, Pepper, Salt </span>
            </li>
            
            <li class="item">
                <img src="images/salad.png" alt="Caesar Salad"><br>
                Caesar Salad
                <span class="facts">*Insert Description of Caesar Salad*</span>
            </li>
            <!-- Add more main dishes as needed -->
        </ul>
    </main>
</body>
</html>
