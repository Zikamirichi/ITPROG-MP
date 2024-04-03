<!DOCTYPE html>
<html lang="en">
<head>
<<<<<<< HEAD
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap" rel="stylesheet">
    <title>GCash</title>
	<style>
		.gcash-prompt {
		  background-color: #f1f1f1;
		  padding: 20px;
          padding-bottom: 110px;
		  border-radius: 5px;
		  text-align: center;
		  margin: 20px auto;
		  width: 400px;
		  height: 400px;
		  font-family: 'Luckiest Guy', cursive;
		  position: relative;
		  aspect-ratio: 1/1;
		}
=======
    <style>
        .gcash-prompt {
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            margin: 20px auto;
            width: 600px; /* Increased width of the card container */
            height: 650px; /* Increased height of the card container */
            font-family: 'Luckiest Guy', cursive;
            position: relative;
            aspect-ratio: 1/1;
        }
>>>>>>> parent of d96e2e4 (Updated)

		.gcash-prompt h2 {
		  margin-top: 0;
		  color: #ffffff;
		  background-color: #D4471F;
		  padding: 10px;
		  border-radius: 5px;
		}

        .gcash-prompt .close {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #D4471F;
            color: #ffffff;
            border: none;
            padding: 10px 20px; /* Increased padding for the close button */
            font-family: 'Luckiest Guy', cursive;
            border-radius: 50%;
            cursor: pointer;
            font-size: 30px; /* Larger font size for the close button */
        }

		.gcash-prompt .close:hover {
		  background-color: #ddd;
		}

        .gcash-prompt .total-bill {
            font-size: 24px; /* Font size for total bill text */
            margin-bottom: 20px; /* Add margin below total bill text */
            font-family: 'Luckiest Guy', cursive; /* Match the font family */
            color: #333; /* Match the font color */
            font-weight: bold; /* Make the font bold */
        }

        .gcash-prompt .qr-code {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 63%; /* Adjust height to accommodate the total bill text */
            margin-top: 100px; /* Adjust margin to leave space for the header */
            margin-bottom: 20px; /* Add margin below the QR code */
        }

        .gcash-prompt .qr-code img {
            max-width: 100%; /* Adjust the size of the QR code image */
            max-height: 100%;
        }

        .gcash-prompt button {
            background-color: #CED3D7;
            color: #000000;
            border: none;
            padding: 15px 45px; /* 30% longer padding */
            border-radius: 50px;
            font-family: 'Luckiest Guy', cursive;
            font-size: 30px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 200px; /* Make the button wider */
            text-transform: uppercase;
            font-weight: bold; /* Make the font bold */
        }

        .gcash-prompt button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div id="gcash-prompt" class="gcash-prompt">
        <link rel="stylesheet" href="../../images/Healthy_Food_QR.jpg">
        <a href="cart.php" class="close">&times;</a>
        <h2>GCASH</h2>
        <div class="qr-code">
            <img src="../../images/Healthy_Food_QR.jpg" alt="QR Code">
        </div>
        <?php
            session_start();
            $totalBill = $_SESSION['totalBill'];
            
            echo "<h3>Total Bill: Php $totalBill</h3>";
        ?>
        <button id="submit-gcash">SUBMIT</button>
    </div>

    <script>
        const submitButton = document.querySelector('#submit-gcash');
        submitButton.addEventListener('click', () => {
            window.location.href = 'paid.php';
        });

        // Add an event listener to the close button
        document.querySelector('.gcash-prompt .close').addEventListener('click', () => {
            location.href = 'payOptions.php';
        });
    </script>
</body>
</html>
    