<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap" rel="stylesheet">
    <style>
            body {
                font-family: 'Luckiest Guy', cursive;
                margin: 0;
                padding: 0;
                background-image: url('../../images/menubg.png'); 
                background-size: cover;
                background-repeat: no-repeat;
                display: flex;
            }

            .payment-successful-prompt {
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            margin: 20px auto;
            width: 300px;
            height: 500px;
            font-family: 'Luckiest Guy', cursive;
            position: relative;
            }

            .payment-successful-prompt h2 {
            margin-top: 0;
            color: #ffffff;
            background-color: #D4471F;
            padding: 10px;
            border-radius: 5px;
            font-size: 24px;
            }

            .payment-successful-prompt .close {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #f1f1f1;
            color: #333;
            border: none;
            padding: 5px 10px;
            font-family: 'Luckiest Guy', cursive;
            border-radius: 50%;
            cursor: pointer;
            font-size: 24px;
            }

            .payment-successful-prompt .close:hover {
            background-color: #ddd;
            }

            .payment-successful-prompt .options {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
            gap: 30px; 
            }

            .payment-successful-prompt .try-again {
            background-color: #4CAF50;
            color: rgb(255, 255, 255);
            border: none;
            padding: 10px;
            font-family: 'Luckiest Guy', cursive;
            border-radius: 5px;cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
            margin-right: 30px;
            }

            .payment-successful-prompt .try-again:hover {
            background-color: #45a049;
            }

            .payment-successful-prompt .choose-another {
            background-color: #000000;
            color: rgb(255, 255, 255);
            border: none;
            padding: 10px;
            font-family: 'Luckiest Guy', cursive;
            border-radius: 5px;cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
            margin-left: 30px;
            }

            .payment-successful-prompt .choose-another:hover {
            background-color: #45a049;
            }

            .order-number {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: 'Luckiest Guy', cursive;
            color: #000000;
            background-color: #615f5f;
            font-size: 13px;
            cursor: not-allowed;
            user-select: none;
            }

            a {
                margin-top: 50px;
                background-color: #CED3D7;
                color: rgb(0, 0, 0);
                border: none;
                padding: 10px;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
                text-decoration: none;
            }

            a:hover {
                background-color: #45a049;
            }
    </style>
</head>
<body>
    <div id="payment-successful-prompt" class="payment-successful-prompt">
        <h2>PAYMENT SUCCESSFULL!</h2>
        <div class="order-details">
            <?php
                session_start();
                $cartID = $_SESSION['cartID'];

                // session stuff
                $totalBill = $_SESSION['totalBill'];

                $currentAmount = isset($_SESSION['currentAmount']) ? $_SESSION['currentAmount'] : $totalBill; // Current amount received
                $change = isset($_SESSION['change']) ? $_SESSION['change'] : 0; // Change to be dispensed

                //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
                $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
                mysqli_select_db($conn, "mydb");

                echo "We recieved a total payment of";
                echo "<h1>PHP " . $currentAmount . "</h1>";

                echo "Please get your change of";
                echo "<h1>PHP " . $change . "</h1>";

                // Generate OR NUM
                $maxORQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(OR_num, 3) AS UNSIGNED)) AS maxOR_ FROM or_");
                $row = mysqli_fetch_array($maxORQuery);
                $maxOR = $row['maxOR_'];

                $newOR = 'or' . ($maxOR + 1); // New OR Number
                $newDate = date("Y-m-d");

                // Insert to DB
                $insertORQuery = "INSERT INTO or_ (OR_num, cart_id, date) VALUES ('$newOR', '$cartID', '$newDate')";
                mysqli_query($conn, $insertORQuery);

                echo "OR Number: ". $newOR. "<br>";
                echo "Date: ". $newDate;

                session_destroy();
            ?>
            <br><br><a href="index.php">Back To Start</a>
        </div>
        
</body>
</html>
