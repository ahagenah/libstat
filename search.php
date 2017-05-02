<?php
	
	require_once 'dblogin.php';
	include_once 'header.php';
	require_once 'functions.php';

	if (isset($_GET['submit'])) {
		if (empty($_GET['name'])) {
		echo "<p>Please fill out all of the form fields!</p>";
		} else {
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) die($conn->connect_error);

		$name = sanitizeMySQL($conn, $_GET['name']);
		$name = sanitizeString($name);

		$query = "SELECT * FROM library WHERE lib_name LIKE '%$name%'";
		$result = $conn->query($query);

		if (!$result) {
			die ("Database access failed: " . $conn->error);
		} else {
			$rows = $result->num_rows;
			if ($rows) {
				echo "<h4>Results</h4>";
				while ($row = $result->fetch_assoc()) {
					echo "<h4><a href=\"library.php?fscs_id=".$row["fscs_id"]."\">".$row["lib_name"]. " - ".$row["city"].", ".$row["state"]."</a>";
					echo "</h4>";
				}
			} else {
				echo "<p>No results!</p>";
			}
			echo "<p>Search Again</p>";
			}
		}
	}
?>
	<form method="get" action="search.php">
		<fieldset>
			<legend>Search for a Library</legend>
			<label for="name">Name:</label>
			<input id="name" type="text" name="name" required><br> 
			<input type="submit" name="submit">
		</fieldset>
		</form>

<?php
	include_once 'footer.php';

?>