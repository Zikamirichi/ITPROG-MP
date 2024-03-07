<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side Dishes</title>
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
        <a href="mains.php">Main</a>
        <a href="sides.php" class="current-page">Sides</a>
        <a href="drink.php">Drinks</a>
        <a href="mainmenu.php">Cart</a>
        <a href="mainmenu.php">Back to Hub</a>
    </nav>
    <main>
        <h1>Side Dishes</h1>
        <ul>
            <li class ="item">
                <img src="images/rice.png" alt="Rice"> <br>    
                Rice
                <span class = "facts">*Insert Rice Description*</span>
            </li>
            
            <li class ="item">
                <img src="images/veg.png" alt="Mixed Vegetables"> <br>    
                Mixed Vegetables
                <span class = "facts">*Insert Mixed Vegetables Description*</span>
            </li>
            
            <li class ="item">
                <img src="images/mash.png" alt="Mashed Potatoes"> <br>   
                Mashed Potatoes
                <span class = "facts">*Insert Mashed Potatoes Description*</span>
            </li>
            <!-- Add more main dishes as needed -->
        </ul>
    </main>
</body>
</html>
