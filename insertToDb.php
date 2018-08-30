<?php

	// Define function to handle basic user input
	function parse_input($data) 
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
 
	// PHP script used to connect to backend Azure SQL database
	require 'ConnectToDatabase.php';

	// Start session for this particular PHP script execution.
	session_start();

	// Define ariables and set to empty values
	$first_name = $last_name = $start_date = $end_date = $vehicle_make = $vehicle_model = NULL;

	// Get input variables
	$first_name= parse_input($_POST['first_name']);
	$last_name= parse_input($_POST['last_name']);
	$start_date= parse_input($_POST['start_date']);
	$end_date= parse_input($_POST['end_date']);
	$vehicle_make= parse_input($_POST['vehicle_make']);
	$vehicle_model= parse_input($_POST['vehicle_model']);

	// Get the authentication claims stored in the Token Store after user logins using Azure Active Directory
	$claims= json_decode($_SERVER['MS_CLIENT_PRINCIPAL'])->claims;
	foreach($claims as $claim)
	{		
		if ( $claim->typ == "http://schemas.xmlsoap.org/ws/2005/05/identity/claims/emailaddress" )
		{
			$userEmail= $claim->val;
			break;
		}
	}

	///////////////////////////////////////////////////////
	//////////////////// INPUT VALIDATION /////////////////
	///////////////////////////////////////////////////////

	//Initialize variable to keep track of any errors
	$anyErrors= FALSE;

	
	///////////////////////////////////////////////////////
	////////// INPUT PARSING AND WRITE TO SQL DB //////////
	///////////////////////////////////////////////////////

	// Only input information into database if there are no errors
	if ( !$anyErrors ) 
	{
		// Connect to Azure SQL Database
		$conn = ConnectToDabase();

		// Build SQL query to insert new expense data into SQL database
		$tsql=
		"INSERT INTO Directory (	
				Person ID,
				FirstName,
				LastName,
				StartDate,
				EndDate,
				VMake,
				VModel,
				Notes)
		VALUES ('" . $userEmail . "',
				'" . $first_name . "', 
				'" . $last_name . "', 
				'" . $start_date . "', 
				'" . $end_date . "', 
				'" . $vehicle_make . "', 
				'" . $vehicle_model . "')";

		// Run query
		$sqlQueryStatus= sqlsrv_query($conn, $tsql);

		// Close SQL database connection
		sqlsrv_close ($conn);
	}

	/* Redirect browser to home page */
	header("Location: /"); 
?>