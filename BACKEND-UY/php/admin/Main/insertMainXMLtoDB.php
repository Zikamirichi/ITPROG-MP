<?php
$conn = mysqli_connect("localhost", "root", "", "mydb");

$affectedRow = 0;

$xml = simplexml_load_file("mains.xml") or die("Error: Cannot create object");

foreach ($xml->children() as $row) {
  echo $mains_id = $row->mains_id;
  echo $name = $row->name;
  echo $price = $row->price;
  echo $nutr_facts_id = $row->nutr_facts_id;
  echo $stocks_id = $row->stocks_id;
  echo "<br />";  
    $sql = "INSERT INTO mains(mains_id, name, price, nutr_facts_id, stocks_id) VALUES ('$mains_id', '$name', '$price', '$nutr_facts_id', '$stocks_id')";
    
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
