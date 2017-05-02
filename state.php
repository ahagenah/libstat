<?php
	require_once 'dblogin.php';
	include_once 'header.php';
	require_once 'functions.php';
?>
<form method="get" action="state.php">
	<fieldset>
		<legend>Find a Library</legend>
		<label for="state">State:</label>
		<select id="state" name="state">
			<option value="AL">Alabama</option>
			<option value="AK">Alaska</option>
			<option value="AZ">Arizona</option>
			<option value="AK">Arkansas</option>
			<option value="CA">California</option>
			<option value="CO">Colorado</option>
			<option value="CT">Connecticut</option>
			<option value="DE">Delaware</option>
			<option value="FL">Florida</option>
			<option value="GA">Georgia</option>
			<option value="HI">Hawaii</option>
			<option value="ID">Idaho</option>
			<option value="IL">Illinois</option>
			<option value="IN">Indiana</option>
			<option value="IA">Iowa</option>
			<option value="KS">Kansas</option>
			<option value="KY">Kentucky</option>
			<option value="LA">Louisiana</option>
			<option value="ME">Maine</option>
			<option value="MA">Massachusetts</option>
			<option value="MI">Michigan</option>
			<option value="MN">Minnesota</option>
			<option value="MS">Mississippi</option>
			<option value="MO">Missouri</option>
			<option value="MT">Montana</option>
			<option value="NE">Nebraska</option>
			<option value="NV">Nevada</option>
			<option value="NH">New Hampshire</option>
			<option value="NJ">New Jersey</option>
			<option value="NM">New Mexico</option>
			<option value="NY">New York</option>
			<option value="NC">North Carolina</option>
			<option value="ND">North Dakota</option>
			<option value="OH">Ohio</option>
			<option value="OK">Oklahoma</option>
			<option value="OR">Oregon</option>
			<option value="PA">Pennsylvania</option>
			<option value="RI">Rhode Island</option>
			<option value="SC">South Carolina</option>
			<option value="SD">South Dakota</option>
			<option value="TN">Tennessee</option>
			<option value="TX">Texas</option>
			<option value="UT">Utah</option>
			<option value="VT">Vermont</option>
			<option value="VA">Virginia</option>
			<option value="WA">Washington</option>
			<option value="WV">West Virginia</option>
			<option value="WI">Wisconsin</option>
			<option value="WY">Wyoming</option>
		</select><br>
		<input type="submit" value="Submit">
	</fieldset>
</form>

<?php
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) die($conn->connect_error);
		if (isset($_GET['state'])) {

		$state = $_GET['state'];

		$state = sanitizeMySQL($conn, $_GET['state']);
		$state = sanitizeString($state);

		$query = 	"SELECT * FROM library 
					NATURAL JOIN revenue 
					WHERE state = \"$state\" AND amount > 0 
					ORDER BY amount DESC";

		$result = $conn->query($query);
		if (!$result) die ("Database access failed: " . $conn->error);
		$rows = $result->num_rows;

		echo "<table><tr> <th>Libray Name</th> <th>City</th><th>State</th><th>Federal Funding</th></tr>";
		$total = 0; //Get total amount of funding
		$average = 0; //To get average
		while ($row = $result->fetch_assoc()) {
			$total = $total + $row["amount"];
			echo "<tr><td>";
			echo "<a href=\"library.php?fscs_id=".$row["fscs_id"]."\">".$row["lib_name"]."</a>";
			echo "</td><td>".$row["city"]." </td>";
			echo "<td>".$row["state"]."</td>";
			echo "<td>".'$'.$row["amount"]."</td>";
			echo '</tr>';
			}
		$newttl = 0;
		$newttl = number_format($total);
		$average = $total/$rows;
		$newavg = 0;
		$newavg = number_format($average, 2);
		echo '</table>';
		echo "<h1>The total amount of Federal Funding in $state is $$newttl</h1>";
		echo "<h1>and the average amount in $state is $$newavg</h1>";
	}	
	
	
	include_once 'footer.php';
?>
