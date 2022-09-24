<?php

	// CONNECTION
	function dbconnect() {

		$servername = "localhost";
		$username = "localhost";
		$password = "root";
		$dbname = "plantdashboard";

		$conn = new mysqli($servername, $username, $password, $dbname);

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		return $conn;
	}

	// GENERIC FUNCTIONS
	function GetColumnOrder($orderdir) {

		switch($orderdir) {
			case 0: return "DESC";
			case 1: return "ASC";
			default: return "DESC";
		}
	}

?>
