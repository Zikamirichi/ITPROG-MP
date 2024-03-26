<?php
    session_start();
    $cartID = $_SESSION['cartID'];

    //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
    $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
    mysqli_select_db($conn, "mydb");

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