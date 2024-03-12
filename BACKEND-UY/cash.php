<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash</title>
</head>
<body>
    <?php
        session_start();
        $totalBill = (double) $_SESSION['totalBill'];

        echo "<h2>Total Bill: $totalBill</h2><br><br>";
    ?>
    <br><br><a href="paid.php">Done</a>
</body>
</html>