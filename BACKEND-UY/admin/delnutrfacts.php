<html>
<head><title>Delete Nutrition Facts</title></head>
<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
Enter Nutrition Facts ID: <input type="text" name="id" size="15" /><br />
<input type="submit" name="enter" value="Enter" /><br /><br />
</form>

<?php
$conn = mysqli_connect("localhost", "root", "12345", "mydb", "3360") or die ("Unable to connect!". mysqli_error($conn) ); // May have to edit connection data on local machine
mysqli_select_db($conn, "mydb");

if(isset($_POST["enter"])){
  $id = $_POST["id"];
  $factsQuery = mysqli_query($conn, "SELECT * FROM nutr_facts WHERE nutr_facts_id='$id'");
  $getFacts = mysqli_fetch_array($factsQuery);
     echo "Nutrition Facts ID: ".$getFacts["nutr_facts_id"]."<br />";
     echo "Description: ".$getFacts["desc"]."<br />";
     echo "Ingredients: ".$getFacts["Ingredients"]."<br />";
     echo "Fat: ".$getFacts["Fat"]."<br />";
     echo "Calories: ".$getFacts["Calories"]."<br />";
     echo "Carbs: ".$getFacts["Carbs"]."<br />";
     echo "Protein: ".$getFacts["Protein"]."<br />";
    	 
	 mysqli_query($conn, "DELETE FROM nutr_facts WHERE nutr_facts_id='".$getFacts['nutr_facts_id']."'");
		 echo "<p>This record has been deleted from the database!</p>";
     
}	 
?>
<hr>
<a href="modnutrfacts.php">Back</a>

</body>
</html>
