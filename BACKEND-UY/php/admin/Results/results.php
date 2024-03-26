<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/admin.css" />
    <title>Results</title>
    <style>
        table {
            width: 80%;
            border-collapse: collapse;
            border: 2px solid black;
            margin: auto;
        }

        th, td {
            padding: 10px;
            border: 1px solid black;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Results Table</h1>
    <?php
    error_reporting(E_ERROR | E_PARSE);
    $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
        mysqli_select_db($conn, "mydb");
        $date = $_GET['date'];
     echo "<h3>Date: '$date' </h3>";
    ?>
    <table>
        <!-- Dishes Sold -->
        <tr>
            <th>Dishes Sold</th>
        </tr>
        <tr>
            <?php
            // Fetch total dishes sold
            $date = $_GET['date'];
            $sql = "SELECT 
                        (total_dish_alacarte.total_dishes_sold + total_dish_combo.total_dishes_sold) AS total_dishes_sold
                    FROM
                    (
                        SELECT 
                            SUM(ot.ordr_quan) AS total_dishes_sold
                        FROM 
                            or_ 
                            JOIN cart c ON c.cart_id = or_.cart_id
                            JOIN ala_carte ac ON ac.cart_id = c.cart_id
                            JOIN order_table ot ON ac.ordr_id = ot.ordr_id
                        WHERE 
                            or_.date = '$date'
                    ) AS total_dish_alacarte,
                    (
                        SELECT 
                            SUM(ot_m.ordr_quan + ot_s.ordr_quan + ot_d.ordr_quan) AS total_dishes_sold
                        FROM 
                            or_ 
                            JOIN cart ca ON ca.cart_id = or_.cart_id
                            JOIN combo co ON co.cart_id = ca.cart_id
                            JOIN cmb_main AS cmb_m ON cmb_m.c_main_id = co.c_main_id
                            JOIN cmb_side AS cmb_s ON cmb_s.c_side_id = co.c_side_id
                            JOIN cmb_drink AS cmb_d ON cmb_d.c_drink_id = co.c_drink_id
                            JOIN order_table AS ot_m ON cmb_m.ordr_id = ot_m.ordr_id
                            JOIN order_table AS ot_s ON cmb_s.ordr_id = ot_s.ordr_id
                            JOIN order_table AS ot_d ON cmb_d.ordr_id = ot_d.ordr_id
                        WHERE 
                            or_.date = '$date'
                    ) AS total_dish_combo;";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                echo "<td>Total: " . $row['total_dishes_sold'] . " dishes</td>";
            } else {
                echo "<td>Error: " . mysqli_error($conn) . "</td>";
            }
            ?>
        </tr>

        <!-- Earnings -->
        <tr>
            <th>Earnings</th>
        </tr>
        <tr>
            <?php 
            // Fetch total earnings
            $sql = "
                SELECT (total_earned_from_combo + total_earned_from_alacarte) AS total_earnings
                FROM (
                    SELECT 
                        SUM(mains.price + side.price + drink.price) AS total_earned_from_combo
                     FROM 
                        or_ 
                        JOIN cart ca ON ca.cart_id = or_.cart_id
                        JOIN combo c ON ca.cart_id = c.cart_id
                        JOIN cmb_main AS cmb_m 
                            ON cmb_m.c_main_id = c.c_main_id
                        JOIN cmb_side AS cmb_s 
                            ON cmb_s.c_side_id = c.c_side_id
                        JOIN cmb_drink AS cmb_d 
                            ON cmb_d.c_drink_id = c.c_drink_id
                        JOIN order_table AS ot_m 
                            ON cmb_m.ordr_id = ot_m.ordr_id
                        JOIN order_table AS ot_s 
                            ON cmb_s.ordr_id = ot_s.ordr_id
                        JOIN order_table AS ot_d 
                            ON cmb_d.ordr_id = ot_d.ordr_id
                        JOIN item i_m 
                            ON i_m.item_id = ot_m.item_id
                        JOIN item i_s 
                            ON i_s.item_id = ot_s.item_id
                        JOIN item i_d 
                            ON i_d.item_id = ot_d.item_id
                        JOIN sides AS side
                            ON i_s.item_id = side.sides_id
                        JOIN mains AS mains 
                            ON i_m.item_id = mains.mains_id
                        JOIN drinks AS drink 
                            ON i_d.item_id = drink.drinks_id
                         WHERE 
                        or_.date = '$date'
                ) AS ComboTotal,
                
                -- Query for Ala_carteTotal
                (
                    SELECT 
                        SUM(COALESCE(mains.price*ot.ordr_quan, 0) + COALESCE(side.price*ot.ordr_quan, 0) + COALESCE(drink.price*ot.ordr_quan, 0)) AS total_earned_from_alacarte
                   FROM 
                        or_ 
                        JOIN cart c ON c.cart_id = or_.cart_id
                        JOIN ala_carte ac ON ac.cart_id = c.cart_id
                        JOIN order_table AS ot 
                            ON ac.ordr_id = ot.ordr_id
                        JOIN item i 
                            ON i.item_id = ot.item_id
                        LEFT JOIN sides AS side 
                            ON i.item_id = side.sides_id
                        LEFT JOIN mains AS mains 
                            ON i.item_id = mains.mains_id
                        LEFT JOIN drinks AS drink 
                            ON i.item_id = drink.drinks_id
                            WHERE 
                        or_.date = '$date'
                ) AS Ala_carteTotal;";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                echo "<td>Total: ₱" . $row['total_earnings'] . "</td>";
            } else {
                echo "<td>Error: " . mysqli_error($conn) . "</td>";
            }
            ?>
        </tr>

        <!-- Discounts Given -->
        <tr>
            <th>Discounts Given</th>
        </tr>
        <tr>
            <?php
            // Fetch total discounts given
            $sql = "SELECT COUNT(c.cmb_id) AS `Total Discounts`
            FROM 
                  or_ or_ JOIN cart ca
                         ON ca.cart_id = or_.cart_id
                         JOIN combo c
                         ON  c.cart_id = ca.cart_id
                         WHERE 
                    or_.date = '$date';";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                echo "<td>Total: " . $row['Total Discounts'] . " discounts</td>";
            } else {
                echo "<td>Error: " . mysqli_error($conn) . "</td>";
            }

            mysqli_close($conn);
            ?>
        </tr>
    </table>
    <br>

    <!-- Dropdown with a Submit Button to Select Distinct Dates -->
    <form action="results.php" method="GET">
        <select name="date">
            <?php
            error_reporting(E_ERROR | E_PARSE);
            $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
            mysqli_select_db($conn, "mydb");
            
            $sql = "SELECT DISTINCT date FROM or_;";
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows > 0) {
                // Output each distinct date as an option in the dropdown
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['date'] . "'>" . $row['date'] . "</option>";
                }
            } else {
                echo "<option value=''>No dates found</option>";
            }

            // Close connection
            mysqli_close($conn);
            ?>
        </select>
        <button type="submit">Submit</button>
    </form>

    <br>
    <div class="back-submit-container">
                    <a href="../adminmenu.php" class="back-button">Back</a>
    </div>
</body>
</html>