<?php
$conn = mysqli_connect("localhost", "root", "", "dbemployees");

$affectedRow = 0;

$xml = simplexml_load_file("xmldata1.xml") or die("Error: Cannot create object");

foreach ($xml->children() as $row) {
  echo $id = $row->id;
  echo $fname = $row->fname;
  echo $lname = $row->lname;
  echo $photo = $row->photo;
  echo "<br />";  
    $sql = "INSERT INTO tblemp(id, fname, lname, photo) VALUES ('" . $id . "','" . $fname . "','" . $lname . "','" . $photo . "')";
    
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
