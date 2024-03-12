<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <style>
        table {
            width: 80%; /* Adjust the width as per your preference */
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
            background-color: #f2f2f2; /* Light gray background for header cells */
        }
    </style>
</head>
<body>
    <h1> Results Table </h1>
   <?php
   error_reporting(E_ERROR | E_PARSE);
   //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
   $conn = mysqli_connect("localhost", "root", "","",3360) or die ("Unable to connect!". mysqli_error($conn) );
   mysqli_select_db($conn, "mydb");
    ?>
<table>
    <!-- Dishes Sold -->
    <tr>
        <th>Dishes Sold</th>
    </tr>
    <tr>
        <?php
        $sql = "SELECT SUM(ot.ordr_quan) AS total_dishes_sold FROM order_table ot";
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
        $sql = "
            SELECT 
                (ComboTotal.total_earned_from_combo + Ala_carteTotal.total_earned_from_alacarte) AS total_earnings
            FROM (
                SELECT 
                    SUM(mains.price + side.price + drink.price) AS total_earned_from_combo
                FROM combo c
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
            ) AS ComboTotal,
            (
                SELECT 
                    SUM(COALESCE(mains.price*ot.ordr_quan, 0) + COALESCE(side.price*ot.ordr_quan, 0) + COALESCE(drink.price*ot.ordr_quan, 0)) AS total_earned_from_alacarte
                FROM 
                    ala_carte ac
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
            ) AS Ala_carteTotal;
            ";

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
        $sql = "SELECT COUNT(c.cmb_id) AS `Total Discounts` FROM combo c";
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
<!-- HINDE GUMAGANA -->
<button onclick="window.location.href = 'adminmenu.php'">Back to Admin Menu</button>

</body>
</html>



