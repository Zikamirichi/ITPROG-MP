<!DOCTYPE html>
<html lang="en">
<head>
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
		  background-color: #f1f1f1;
		  color: #333;
		  border: none;
		  padding: 5px 10px;
		  font-family: 'Luckiest Guy', cursive;
		  border-radius: 50%;
		  cursor: pointer;
		}

		.gcash-prompt .close:hover {
		  background-color: #ddd;
		}

		.qr-code {
		  display: flex;
		  justify-content: center;
		  align-items: center;
		  height: 80%;
		}

		.qr-code img {
		  max-width: 100%;
		  max-height: 100%;
		}

         a {
      margin-bottom: 10px;
      background-color: #CED3D7;
      color: rgb(0, 0, 0);
      border: none;
      padding: 10px;
      border-radius: 5px;
      font-family: 'Luckiest Guy', cursive;
      font-size: 25px;
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
    <div id="gcash-prompt" class="gcash-prompt">
        <link rel="stylesheet" href="../../images/Healthy_Food_QR.jpg">
        <span class="close">&times;</span>
        <h2>GCASH</h2>
        <div class="qr-code">
            <img src="../../images/Healthy_Food_QR.jpg" alt="QR Code">
        </div>
        <?php
            session_start();
            $totalBill = $_SESSION['totalBill'];
            
            echo "<h3>Total Bill: Php $totalBill</h3>";
        ?>
        <a href="paid.php">Done</a>
    </div>    
</body>
</html>
    