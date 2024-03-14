<?php
$conn = mysqli_connect("localhost", "root", "", "mydb");

$affectedRow = 0;

$xml = simplexml_load_file("drinks.xml") or die("Error: Cannot create object");

foreach ($xml->children() as $row) {
  echo $drinks_id = $row->drinks_id;
  echo $names = $row->names;
  echo $price = $row->price;
  echo $nutr_facts_id = $row->nutr_facts_id;
  echo $stocks_id = $row->stocks_id;
  echo "<br />";  
    $sql = "INSERT INTO drinks(drinks_id, names, price, nutr_facts_id, stocks_id) VALUES ('$drinks_id', '$names', '$price', '$nutr_facts_id', '$stocks_id')";
    
    $result = mysqli_query($conn, $sql);
    
    if (!empty($result)) {
        $affectedRow ++;
    } else {
        $error_message = mysqli_error($conn) . "\n";
    }
}
?>
<h2>Insert XML Data to MySql Table Output</h2>
<?php
if ($affectedRow > 0) {
    $message = $affectedRow . " records inserted";
} else {
    $message = "No records inserted";
}

echo "<h3><font color='green'>" .$message."</font></h2>";
?>