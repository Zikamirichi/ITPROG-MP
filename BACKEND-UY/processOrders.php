<?php

    //CHANGE $CONN VARIABLES DEPENDING ON PERSONAL DEVICE SETTINGS
    $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
    mysqli_select_db($conn, "mydb");
    
    session_start();
    $cartID = $_SESSION['cartID']; // Get the cart ID of the current user


    if (isset($_SESSION['mains'])) { // Check if mains were ordered by the customer
        $mains = $_SESSION['mains']; // Get the Mains currently ordered in the session
    }
    else {

        $mains = [];
    }

    if (isset($_SESSION['sides'])) { // Check if sides were ordered by the customer
        $sides = $_SESSION['sides']; // Get the Sides currently ordered in the session
    }
    else {

        $sides = [];
    }

    if (isset($_SESSION['drinks'])) { // Check if drinks were ordered by the customer
        $drinks = $_SESSION['drinks']; // Get the Drinks currently ordered in the session
    }
    else {

        $drinks = [];
    }

    // COMBO PROCESSING
    if (isset($mains, $sides, $drinks)) { // Check if there are at least 1 of each mains, sides, drinks in the order

        $combos = min(count($mains), count($sides), count($drinks)); // Get the minimum of all order types to determine the number of combos made

        for ($i = 0; $i < $combos; $i++) { // Iterate over all combos made

            $mainOrder = $mains[$i]; 
            $sideOrder = $sides[$i];
            $drinkOrder = $drinks[$i];

            // Get The Quantity of the main in the order
            $mainQuantityQuery = "SELECT ordr_quan FROM order_table WHERE ordr_id = '$mainOrder'";
            $mainQuantityExec = mysqli_query($conn, $mainQuantityQuery);
            $mainQuantityFetch = mysqli_fetch_assoc($mainQuantityExec);
            $mainQuantity = $mainQuantityFetch['ordr_quan'];

            // Get The Quantity of the side in the order
            $sideQuantityQuery = "SELECT ordr_quan FROM order_table WHERE ordr_id = '$sideOrder'";
            $sideQuantityExec = mysqli_query($conn, $sideQuantityQuery);
            $sideQuantityFetch = mysqli_fetch_assoc($sideQuantityExec);
            $sideQuantity = $sideQuantityFetch['ordr_quan'];

            echo $drinkOrder;
            // Get The Quantity of the drink in the order
            $drinkQuantityQuery = "SELECT ordr_quan FROM order_table WHERE ordr_id = '$drinkOrder'";
            $drinkQuantityExec = mysqli_query($conn, $drinkQuantityQuery);
            $drinkQuantityFetch = mysqli_fetch_assoc($drinkQuantityExec);
            $drinkQuantity = $drinkQuantityFetch['ordr_quan'];

            // Mains Queries (for cmb_main table)
            $maxMainQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(c_main_id, 4) AS UNSIGNED)) AS maxMain FROM cmb_main"); // Query to get current max cmb_main
            $mainFetch = mysqli_fetch_array($maxMainQuery);                                                                        // SUBSTRING 4 to remove the "cbm" part
            $maxMainID = $mainFetch['maxMain'];
            $nextMainID = 'cbm' . $maxMainID + 1; // Get a new cbm value by adding 1 to the max
            
            $mainsComboQuery = "INSERT INTO cmb_main (c_main_id, ordr_id)
                                VALUES ('$nextMainID', '$mainOrder');"; // Query the DB to insert the main order to cmb_main
            mysqli_query($conn, $mainsComboQuery);

            // Sides Queries (for cmb_side table)
            $maxSideQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(c_side_id, 4) AS UNSIGNED)) AS maxSide FROM cmb_side");
            $sideFetch = mysqli_fetch_array($maxSideQuery);
            $maxSideID = $sideFetch['maxSide'];
            $nextSideID = 'cbs' . $maxSideID + 1; // Get a new cbs value by adding 1 to the max

            $sidesComboQuery = "INSERT INTO cmb_side (c_side_id, ordr_id)
                                VALUES ('$nextSideID', '$sideOrder')"; // Query the DB to insert the side order to cmb_side
            mysqli_query($conn, $sidesComboQuery);

            // Drinks Queries (for cmb_drink table)
            $maxDrinkQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(c_drink_id, 4) AS UNSIGNED)) AS maxDrink FROM cmb_drink");
            $drinkFetch = mysqli_fetch_array($maxDrinkQuery);
            $maxDrinkID = $drinkFetch['maxDrink'];
            $nextDrinkID = 'cbd' . $maxDrinkID + 1; // Get a new cbd value by adding 1 to the max

            $drinksComboQuery = "INSERT INTO cmb_drink (c_drink_id, ordr_id)
                                VALUES ('$nextDrinkID', '$drinkOrder')"; // Query the DB to insert the drink order to cmb_drink
            mysqli_query($conn, $drinksComboQuery);

            // Combo Table Queries
            $maxComboQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(cmb_id, 4) AS UNSIGNED)) AS maxComboID FROM combo"); // Get Current Maximum Combo ID
            $comboFetch = mysqli_Fetch_array($maxComboQuery);
            $maxComboID = $comboFetch['maxComboID'];
            $nextComboID = 'co_' . sprintf("%02d", $maxComboID + 1); // Get the new combo ID

            $comboQuery = "INSERT INTO combo (cmb_id, cart_id, c_main_id, c_side_id, c_drink_id)
                            VALUES ('$nextComboID','$cartID', '$nextMainID', '$nextSideID', '$nextDrinkID')"; // Query the DB to insert the combo items to combo table
            mysqli_query($conn, $comboQuery);
            

            // For Mains
            if ($mainQuantity > 1) { // If an order is part of the combo meal but is selected to be more than 1 quantity
                                        // For example. Chicken was selected with 2 quantity. 1 Chicken goes to a combo while the other to ala carte
                                        // Therefore, the order is split. The order is decremented so that combo only has 1 chicken,
                                        // Then a new order is created with the remaining chicken to be put in ala carte.

                $updateComboMainQuantity = "UPDATE order_table SET ordr_quan = 1 WHERE ordr_id = '$mainOrder'"; // Update the quantity to 1 for the main to be placed in combo
                mysqli_query($conn, $updateComboMainQuantity);

                // Get Current Max order_id from table 
                $maxOrderQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ordr_id, 2) AS UNSIGNED)) AS max_orderID FROM order_table");
                $row = mysqli_fetch_assoc($maxOrderQuery); 
                $max_orderID = $row['max_orderID'];
                $newMainOrderID = 'o' . ($max_orderID + 1); // The order ID to be used for the new order made

                $newMainQuantity = $mainQuantity - 1; // Subtract 1 to lessen the order that went to the combo

                // Get Item ID from order table associated with the main order ID
                $newMainItemQuery = "SELECT item_id FROM order_table WHERE ordr_id = '$mainOrder'";
                $newMainItemExec = mysqli_query($conn, $newMainItemQuery);
                $newMainItemFetch = mysqli_fetch_assoc($newMainItemExec);
                $newMainItemID = $newMainItemFetch['item_id'];

                $insertNewMainQuery = "INSERT INTO order_table (ordr_id, ordr_quan, item_id)
                                        VALUES ('$newMainOrderID', '$newMainQuantity', '$newMainItemID')"; // Insert the new order to order table
                mysqli_query($conn, $insertNewMainQuery);

                $maxAlaCarteQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ala_id, 2) AS UNSIGNED)) AS maxAlaID FROM ala_carte");
                $maxAlaCarteFetch = mysqli_fetch_array($maxAlaCarteQuery);
                $maxAlaCarteID = $maxAlaCarteFetch['maxAlaID'];
                $newAlaCarteID = 'a' . sprintf("%02d", $maxAlaCarteID + 1); // The order ID to be used for the new order made

                $insertAlacarteQuery = "INSERT INTO ala_carte (ala_id, cart_id, ordr_id) 
                                        VALUES ('$newAlaCarteID','$cartID','$newMainOrderID')"; // Insert the new order to ala carte table
                mysqli_query($conn, $insertAlacarteQuery);

                //array_push($mains, $newMainOrderID);
                //$_SESSION['mains'] = $mains;
            }

            // For Sides
            if ($sideQuantity > 1) {
                // Update the quantity of the side order to 1 for the combo
                $updateComboSideQuantity = "UPDATE order_table SET ordr_quan = 1 WHERE ordr_id = '$sideOrder'";
                mysqli_query($conn, $updateComboSideQuantity);
            
                // Generate a new order ID for the remaining quantity
                $maxOrderQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ordr_id, 2) AS UNSIGNED)) AS max_orderID FROM order_table");
                $row = mysqli_fetch_assoc($maxOrderQuery);
                $max_orderID = $row['max_orderID'];
                $newSideOrderID = 'o' . ($max_orderID + 1); // The order ID to be used for the new order made
            
                $newSideQuantity = $sideQuantity - 1; // Subtract 1 to lessen the order that went to the combo
            
                // Get Item ID from order table associated with the side order ID
                $newSideItemQuery = "SELECT item_id FROM order_table WHERE ordr_id = '$sideOrder'";
                $newSideItemExec = mysqli_query($conn, $newSideItemQuery);
                $newSideItemFetch = mysqli_fetch_assoc($newSideItemExec);
                $newSideItemID = $newSideItemFetch['item_id'];
            
                // Insert the new order into the order_table
                $insertNewSideQuery = "INSERT INTO order_table (ordr_id, ordr_quan, item_id)
                                        VALUES ('$newSideOrderID', '$newSideQuantity', '$newSideItemID')";
                mysqli_query($conn, $insertNewSideQuery);

                $maxAlaCarteQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ala_id, 2) AS UNSIGNED)) AS maxAlaID FROM ala_carte");
                $maxAlaCarteFetch = mysqli_fetch_array($maxAlaCarteQuery);
                $maxAlaCarteID = $maxAlaCarteFetch['maxAlaID'];
                $newAlaCarteID = 'a' . sprintf("%02d", $maxAlaCarteID + 1); // The order ID to be used for the new order made

                $insertAlacarteQuery = "INSERT INTO ala_carte (ala_id, cart_id, ordr_id) 
                                        VALUES ('$newAlaCarteID','$cartID','$newSideOrderID')"; // Insert the new order to ala carte table
                mysqli_query($conn, $insertAlacarteQuery);

                //array_push($sides, $newMainOrderID);
                //$_SESSION['sides'] = $sides;
            }
            
            if ($drinkQuantity > 1) {
                // Update the quantity of the drink order to 1 for the combo
                $updateComboDrinkQuantity = "UPDATE order_table SET ordr_quan = 1 WHERE ordr_id = '$drinkOrder'";
                mysqli_query($conn, $updateComboDrinkQuantity);
            
                // Generate a new order ID for the remaining quantity
                $maxOrderQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ordr_id, 2) AS UNSIGNED)) AS max_orderID FROM order_table");
                $row = mysqli_fetch_assoc($maxOrderQuery);
                $max_orderID = $row['max_orderID'];
                $newDrinkOrderID = 'o' . ($max_orderID + 1); // The order ID to be used for the new order made
            
                $newDrinkQuantity = $drinkQuantity - 1; // Subtract 1 to lessen the order that went to the combo
            
                // Get Item ID from order table associated with the drink order ID
                $newDrinkItemQuery = "SELECT item_id FROM order_table WHERE ordr_id = '$drinkOrder'";
                $newDrinkItemExec = mysqli_query($conn, $newDrinkItemQuery);
                $newDrinkItemFetch = mysqli_fetch_assoc($newDrinkItemExec);
                $newDrinkItemID = $newDrinkItemFetch['item_id'];
            
                // Insert the new order into the order_table
                $insertNewDrinkQuery = "INSERT INTO order_table (ordr_id, ordr_quan, item_id)
                                        VALUES ('$newDrinkOrderID', '$newDrinkQuantity', '$newDrinkItemID')";
                mysqli_query($conn, $insertNewDrinkQuery);

                $maxAlaCarteQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ala_id, 2) AS UNSIGNED)) AS maxAlaID FROM ala_carte");
                $maxAlaCarteFetch = mysqli_fetch_array($maxAlaCarteQuery);
                $maxAlaCarteID = $maxAlaCarteFetch['maxAlaID'];
                $newAlaCarteID = 'a' . sprintf("%02d", $maxAlaCarteID + 1); // The order ID to be used for the new order made

                $insertAlacarteQuery = "INSERT INTO ala_carte (ala_id, cart_id, ordr_id) 
                                        VALUES ('$newAlaCarteID','$cartID','$newDrinkOrderID')"; // Insert the new order to ala carte table
                mysqli_query($conn, $insertAlacarteQuery);

                //array_push($drinks, $newMainOrderID);
                //$_SESSION['drinks'] = $drinks;
            }
        }

        unset($_SESSION['mains']); // Unset Session arrays to avoid duplicate entries
        unset($_SESSION['sides']); 
        unset($_SESSION['drinks']);
    }

    // Ala Carte Processing
    // Process $mains orders
    $maxAlacarteQuery = mysqli_query($conn, "SELECT MAX(CAST(SUBSTRING(ala_id, 2) AS UNSIGNED)) AS maxAlacarteID FROM ala_carte"); // Get Current Maximum Ala Carte ID
    $alacarteFetch = mysqli_Fetch_array($maxAlacarteQuery);
    $maxAlacarteID = $alacarteFetch['maxAlacarteID'];

    if ($mains != NULL) {

        foreach ($mains as $orderID) {
        
          // Check if order ID already exists
          $checkQuery = "SELECT * FROM ala_carte WHERE ordr_id='$orderID' AND cart_id='$cartID'";
          $result = mysqli_query($conn, $checkQuery);
          
          if (mysqli_num_rows($result) == 0) {  
            // Order doesn't exist, insert
            $nextAlacarteID = 'a' . sprintf("%02d", $maxAlacarteID + 1);
            $alacarteQuery = "INSERT INTO ala_carte (ala_id, ordr_id, cart_id)
                              VALUES ('$nextAlacarteID','$orderID', '$cartID')";
            mysqli_query($conn, $alacarteQuery);
      
            $maxAlacarteID++;
          }
        }
      }

      if ($sides != NULL) {

        foreach ($sides as $orderID) {
      
          // Check if order ID already exists
          $checkQuery = "SELECT * FROM ala_carte WHERE ordr_id='$orderID' AND cart_id='$cartID'";
          $result = mysqli_query($conn, $checkQuery);
      
          if (mysqli_num_rows($result) == 0) {
            // Order doesn't exist, insert
            $nextAlacarteID = 'a' . sprintf("%02d", $maxAlacarteID + 1);
            $alacarteQuery = "INSERT INTO ala_carte (ala_id, ordr_id, cart_id)
                              VALUES ('$nextAlacarteID','$orderID', '$cartID')";
            mysqli_query($conn, $alacarteQuery);
      
            $maxAlacarteID++;
          }
        }
      }
      
      if ($drinks != NULL) {
      
        foreach ($drinks as $orderID) {
      
          // Check if order ID already exists  
          $checkQuery = "SELECT * FROM ala_carte WHERE ordr_id='$orderID' AND cart_id='$cartID'";
          $result = mysqli_query($conn, $checkQuery);
      
          if (mysqli_num_rows($result) == 0) {
            // Order doesn't exist, insert
            $nextAlacarteID = 'a' . sprintf("%02d", $maxAlacarteID + 1);
            $alacarteQuery = "INSERT INTO ala_carte (ala_id, ordr_id, cart_id)
                              VALUES ('$nextAlacarteID','$orderID', '$cartID')";
            mysqli_query($conn, $alacarteQuery);
      
            $maxAlacarteID++;
          }
        }
      }

    // Query to Delete Comboed Items fro the ala carte table. With respect to the cart id of the ala carte table
    $deleteAlacarteQuery = "DELETE FROM ala_carte
    WHERE ordr_id IN (
        SELECT ala_carte.ordr_id FROM ala_carte
        JOIN order_table ON ala_carte.ordr_id = order_table.ordr_id
        JOIN cmb_main ON order_table.ordr_id = cmb_main.ordr_id
        UNION
        SELECT ala_carte.ordr_id FROM ala_carte
        JOIN order_table ON ala_carte.ordr_id = order_table.ordr_id
        JOIN cmb_side ON order_table.ordr_id = cmb_side.ordr_id
        UNION
        SELECT ala_carte.ordr_id FROM ala_carte
        JOIN order_table ON ala_carte.ordr_id = order_table.ordr_id
        JOIN cmb_drink ON order_table.ordr_id = cmb_drink.ordr_id)
    AND ala_carte.cart_id = '$cartID'";

    mysqli_query($conn, $deleteAlacarteQuery);

    header("Location: cart.php");