<?php
	
	require_once 'dblogin.php';
	include_once 'header.php';
	require_once 'functions.php';

	if (isset($_GET['fscs_id'])) { 
	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error) die($conn->connect_error);

	$name = sanitizeMySQL($conn, $_GET['fscs_id']);
	
	$query =	"SELECT fscs_id, lib_name, circulation, users, visits, total_programs, program_attendance FROM library NATURAL JOIN library_stat WHERE fscs_id="."\"".$_GET['fscs_id']."\"";

	$result = $conn->query($query);
	if (!$result) die ("Database access failed: " . $conn->error);
	$rows = $result->num_rows;	

	while ($row = $result->fetch_assoc()) {
			echo "<h2>Library</h2>";
			echo "<h4>".$row["lib_name"]."</h4>";
			echo "<h2>Number of Users</h2>";
			echo "<h4>".$row["users"]." </h4>";
			echo "<h2>Total Circulation</h2>";
			echo "<h4>".$row["circulation"]."</h4>";
			echo "<h2>Total Visits</h2>";
			echo "<h4>".$row["visits"]."</h4>";
			echo "<h2>Total Programs</h2>";
			echo "<h4>".$row["total_programs"]."</h4>";
			echo "<h2>Program Attendance</h2>";
			echo "<h4>".$row["program_attendance"]."</h4>";
			}

}
	else{

	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error) die($conn->connect_error);

	$query = "SELECT * FROM library";

	$result = $conn->query($query);
	if (!$result) die ("Database access failed: " . $conn->error);
	$rows = $result->num_rows;

	while ($row = $result->fetch_assoc()) {
		echo "<h4><a href=\"library.php?fscs_id=".$row["fscs_id"]."\">".$row["lib_name"]. " - ".$row["city"].", ".$row["state"]."</a>";
					echo "</h4>";
	}

	}
?>



<?php
	include_once 'footer.php';

?>