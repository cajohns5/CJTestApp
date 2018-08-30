<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US"> 

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title> 
		Microsoft Directory
	</title>


	<style>
		.error {color: #FF0000;}
	</style>

	<!-- Include CSS for different screen sizes -->
	<link rel="stylesheet" type="text/css" href="defaultstyle.css">
</head>

<body>

<?php
	
	require 'connectToDatabase.php';

	// Connect to Azure SQL Database
	$conn = ConnectToDabase();

	
	// Close SQL database connection
	sqlsrv_close ($conn);
?>

<div class="intro">

	<h2> MIcrosoft Directory </h2>

</div>

<!-- Define web form. 
The array $_POST is populated after the HTTP POST method.
The PHP script insertToDb.php will be executed after the user clicks "Submit"-->
<div class="container">
	<form action="insertToDb.php" method="post">

		<label>First Name:</label>
		<input type="text" name="first_name" required>

		<label>Last Name:</label>
		<input type="text" name="last_name" required>

		<label>Start Date:</label>
		<input type="text" name="start_date" required>

		<label>End Date:</label>
		<input type="text" name="end_date" required>

		<label>Vehicle Make:</label>
		<input type="text" name="vehicle_make" required>

		<label>Vehicle Model:</label>
		<input type="text" name="vehicle_model" required>

		<button type="submit">Submit</button>
	</form>
</div>

</body>
</html>
