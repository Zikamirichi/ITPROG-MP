<?php
    $conn = mysqli_connect("localhost", "root", "") or die ("Unable to connect!". mysqli_error($conn) );
    mysqli_select_db($conn, "mydb");

    session_start();
    $cartID = $_SESSION['cartID'];
    $orderIDArray = array(); // Initialize array to store ordr_ids linked to the current $cartID

    // Get order IDs from ala carte
    $getAlaOrderIDs = "SELECT ala_carte.ordr_id, order_table.item_id  
                  FROM ala_carte 
                  JOIN order_table ON ala_carte.ordr_id = order_table.ordr_id
                  WHERE ala_carte.cart_id = '$cartID'";
    $alaOrderResults = mysqli_query($conn, $getAlaOrderIDs);

    // Loop through ala carte orders
    while($row = mysqli_fetch_assoc($alaOrderResults)) {

        $orderID = $row['ordr_id'];
        $itemID = $row['item_id'];

        // Check item_id format
        if (substr($itemID, 0, 2) == 'i1') {
            
            // Update stocks from mains table
            $getAlaDetails = "SELECT mains.stocks_id 
                            FROM order_table JOIN item ON order_table.item_id = item.item_id 
                            JOIN mains ON item.item_id = mains.mains_id
                            WHERE ordr_id = '$orderID'";
            
            $alaDetailsResult = mysqli_query($conn, $getAlaDetails);
            $alaDetailsRow = mysqli_fetch_assoc($alaDetailsResult);
            $stocksID = $alaDetailsRow['stocks_id']; //or sides/drinks
                            
        } 
        
        else if (substr($itemID, 0, 2) == 'i2') {

            // Update stocks from sides table
            $getAlaDetails = "SELECT sides.stocks_id  
                            FROM order_table JOIN item ON order_table.item_id = item.item_id
                            JOIN sides ON item.item_id = sides.sides_id
                            WHERE ordr_id = '$orderID'";
            
            $alaDetailsResult = mysqli_query($conn, $getAlaDetails);
            $alaDetailsRow = mysqli_fetch_assoc($alaDetailsResult);
            $stocksID = $alaDetailsRow['stocks_id'];           
        } 
        
        else if (substr($itemID, 0, 2) == 'i3') {

            // Update stocks from drinks table
            $getAlaDetails = "SELECT drinks.stocks_id
                            FROM order_table JOIN item ON order_table.item_id = item.item_id
                            JOIN drinks ON item.item_id = drinks.drinks_id
                            WHERE ordr_id = '$orderID'";
        
            $alaDetailsResult = mysqli_query($conn, $getAlaDetails);
            $alaDetailsRow = mysqli_fetch_assoc($alaDetailsResult);
            $stocksID = $alaDetailsRow['stocks_id']; 
        }
        
        // Increment stocks
        $incrementStocks = "UPDATE stocks SET quantity = quantity + 1 WHERE stocks_id = '$stocksID'";
        mysqli_query($conn, $incrementStocks);

        // Add to array
        $orderIDArray[] = $orderID;
    }
    
    // Get combo order IDs
    $getComboOrderIDs = "SELECT c_main_id, c_side_id, c_drink_id FROM combo WHERE cart_id = '$cartID'";
    $comboOrderResults = mysqli_query($conn, $getComboOrderIDs);
    
    // Loop through combo orders 
    while($row = mysqli_fetch_assoc($comboOrderResults)) {
    
        $cMainID = $row['c_main_id'];
        $cSideID = $row['c_side_id'];
        $cDrinkID = $row['c_drink_id'];
      
        // Get order IDs
        $mainOrderIDQuery = "SELECT ordr_id FROM cmb_main WHERE c_main_id = '$cMainID'";
        $mainOrderResult = mysqli_query($conn, $mainOrderIDQuery);
        $mainOrderRow = mysqli_fetch_assoc($mainOrderResult);
        $mainOrderID = $mainOrderRow['ordr_id'];
      
        $sideOrderIDQuery = "SELECT ordr_id FROM cmb_side WHERE c_side_id = '$cSideID'";
        $sideOrderResult = mysqli_query($conn, $sideOrderIDQuery);
        $sideOrderRow = mysqli_fetch_assoc($sideOrderResult);
        $sideOrderID = $sideOrderRow['ordr_id'];
      
        $drinkOrderIDQuery = "SELECT ordr_id FROM cmb_drink WHERE c_drink_id = '$cDrinkID'";
        $drinkOrderResult = mysqli_query($conn, $drinkOrderIDQuery);
        $drinkOrderRow = mysqli_fetch_assoc($drinkOrderResult);
        $drinkOrderID = $drinkOrderRow['ordr_id'];
      
        // Use order IDs to get stocks_id
        $mainStocksIDQuery = "SELECT mains.stocks_id 
                     FROM order_table
                     JOIN item ON order_table.item_id = item.item_id
                     JOIN mains ON item.item_id = mains.mains_id
                     WHERE order_table.ordr_id = '$mainOrderID'";
        $mainStocksResult = mysqli_query($conn, $mainStocksIDQuery);
        $mainStockRow = mysqli_fetch_assoc($mainStocksResult);
        $mainStocksID = $mainStockRow['stocks_id'];

        $sideStocksIDQuery = "SELECT sides.stocks_id 
                     FROM order_table
                     JOIN item ON order_table.item_id = item.item_id
                     JOIN sides ON item.item_id = sides.sides_id
                     WHERE order_table.ordr_id = '$sideOrderID'";
        $sideStocksResult = mysqli_query($conn, $sideStocksIDQuery);
        $sideStockRow = mysqli_fetch_assoc($sideStocksResult);
        $sideStocksID = $sideStockRow['stocks_id'];

        $drinkStocksIDQuery = "SELECT drinks.stocks_id 
                     FROM order_table
                     JOIN item ON order_table.item_id = item.item_id
                     JOIN drinks ON item.item_id = drinks.drinks_id
                     WHERE order_table.ordr_id = '$drinkOrderID'";
        $drinkStocksResult = mysqli_query($conn, $drinkStocksIDQuery);
        $drinkStockRow = mysqli_fetch_assoc($drinkStocksResult);
        $drinkStocksID = $drinkStockRow['stocks_id'];
      
        // Increment stocks
        $incrementMainStocks = "UPDATE stocks SET quantity = quantity + 1 WHERE stocks_id = '$mainStocksID'";
        mysqli_query($conn, $incrementMainStocks);

        $incrementSideStocks = "UPDATE stocks SET quantity = quantity + 1 WHERE stocks_id = '$sideStocksID'";
        mysqli_query($conn, $incrementSideStocks);

        $incrementDrinkStocks = "UPDATE stocks SET quantity = quantity + 1 WHERE stocks_id = '$drinkStocksID'";
        mysqli_query($conn, $incrementDrinkStocks);
    }

    // Delete ala carte entries for this cart 
    $deleteAlaCarte = "DELETE FROM ala_carte WHERE cart_id = '$cartID'";
    mysqli_query($conn, $deleteAlaCarte);

    // Delete cmb_main, cmb_side and cmb_drink entries for this cart
    $getComboIDs = "SELECT c_main_id, c_side_id, c_drink_id FROM combo WHERE cart_id = '$cartID'";
    $comboIDsResult = mysqli_query($conn, $getComboIDs);

    while($row = mysqli_fetch_assoc($comboIDsResult)) {

        $cMainID = $row['c_main_id'];
        $cSideID = $row['c_side_id'];
        $cDrinkID = $row['c_drink_id'];
      
        $deleteMain = "DELETE FROM cmb_main WHERE c_main_id = '$cMainID'";
        mysqli_query($conn, $deleteMain);

        $deleteSide = "DELETE FROM cmb_side WHERE c_side_id = '$cSideID'";
        mysqli_query($conn, $deleteSide); 

        $deleteDrink = "DELETE FROM cmb_drink WHERE c_drink_id = '$cDrinkID'";
        mysqli_query($conn, $deleteDrink);
      }
    
    // Delete Combo table entries
    $deleteCombos = "DELETE FROM combo WHERE cart_id = '$cartID'";
    mysqli_query($conn, $deleteCombos);
    
    // Delete order table entries
    foreach ($orderIDArray as $orderID) {
        
        $deleteOrder = "DELETE FROM order_table WHERE ordr_id = '$orderID'";
        mysqli_query($conn, $deleteOrder);
    }

    $delteOR = "DELETE FROM OR_ WHERE cart_id = '$cartID'";
    mysqli_query($conn, $delteOR);

    // Delete Cart ID
    $deleteCart = "DELETE FROM cart WHERE cart_id = '$cartID'";
    mysqli_query($conn, $deleteCart);

    session_destroy(); // Destroy the current session
    header("Location: index.php"); // Return to homepage
    
