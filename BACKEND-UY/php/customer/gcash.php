<!DOCTYPE html>
<html>
<head>
    <style>
        .gcash-prompt {
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            margin: 20px auto;
            width: 600px; 
            height: 650px; 
            font-family: 'Luckiest Guy', cursive;
            position: relative;
            aspect-ratio: 1/1;
        }

        .gcash-prompt h2 {
            margin-top: 0;
            color: #ffffff;
            background-color: #D4471F;
            padding: 30px; 
            border-radius: 5px;
            font-size: 36px; 
            font-weight: bold; 
            width: 90.5%; 
            position: absolute;
            top: 0;
            left: 0;
        }

        .gcash-prompt .close {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #D4471F;
            color: #ffffff;
            border: none;
            padding: 10px 20px; 
            font-family: 'Luckiest Guy', cursive;
            border-radius: 50%;
            cursor: pointer;
            font-size: 30px; 
        }

        .gcash-prompt .close:hover {
            background-color: #B42B00;
        }

        .gcash-prompt .total-bill {
            font-size: 24px; /
            margin-bottom: 20px; 
            font-family: 'Luckiest Guy', cursive; 
            color: #333; 
            font-weight: bold;
        }

        .gcash-prompt .qr-code {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 63%; 
            margin-top: 100px;
            margin-bottom: 20px;
        }

        .gcash-prompt .qr-code img {
            max-width: 100%; 
            max-height: 100%;
        }

        .gcash-prompt button {
            background-color: #CED3D7;
            color: #000000;
            border: none;
            padding: 15px 45px; 
            border-radius: 50px;
            font-family: 'Luckiest Guy', cursive;
            font-size: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 200px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .gcash-prompt button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div id="gcash-prompt" class="gcash-prompt">
        <h2>GCASH PAYMENT</h2>
        <span class="close">&times;</span>
        <div class="qr-code">
            <img src="Healthy_Food_QR.jpg" alt="QR Code">
        </div>
        <?php
            session_start();
            $totalBill = $_SESSION['totalBill'];
            echo "<p class='total-bill'>Total Bill: Php $totalBill</p>";
        ?>
        <button id="submit-gcash">SUBMIT</button>
    </div>

    <script>
        const submitButton = document.querySelector('#submit-gcash');
        submitButton.addEventListener('click', () => {
            window.location.href = 'paid.php';
        });

        
        document.querySelector('.gcash-prompt .close').addEventListener('click', () => {
            location.href = 'payOptions.php';
        });
    </script>
</body>
</html>
