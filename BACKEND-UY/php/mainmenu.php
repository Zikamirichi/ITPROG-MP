<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="navbar.css" />
    <title>Main Menu</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('../images/menubg.png'); 
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
        }

        .navigation-bar {
            width: 5%;
            height: 100vh;
            background-color: #D4471F;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .right-container{
            flex: 1;
            align-items: center;
        }

        .select-text{
            color: #311712;
            font-family: "Luckiest Guy", cursive;
            font-weight: 400;
            font-style: normal;
            font-size: 50px;
            text-align: center;
            margin-top: 5%;
            margin-bottom: 5%;
            
        }

        .images-container {
            display: flex;
            justify-content: space-between;
        }

        .button-dish {
            padding: 10px;
            background-color: #F4F4F4; 
            border: none;
            border-radius: 15px;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 5%;
            outline: none;
            box-shadow: 0 20px #999;
        }

        .button-dish img {
            width: 80%;
        }

        .button-dish:hover {
            background-color: #CED3D7;
        }

        .button-dish:active {
            filter: invert(100%);
            background-color: #ff99cc;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }   

    </style>
</head>
<body>
    <div class="navigation-bar">&nbsp;</div>
    <div class="right-container">
        <div class="select-text">Select the Dish you wish to order </div>
        <div class="images-container">
            <a href="mains.php" class="button-dish">
                <img src="../images/main-button.png" alt="Main Dishes">
            </a>
            <a href="sides.php" class="button-dish">
                <img src="../images/side-button.png" alt="Side Dishes">
            </a>
            <a href="drinks.php" class="button-dish">
                <img src="../images/drink-button.png" alt="Drinks">
            </a>
        </div>
</body>
</html>
