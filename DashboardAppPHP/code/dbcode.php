<?php

	// CONNECTION
	function dbconnect() {

		$servername = "sql210.epizy.com";
		$username = "epiz_32422288";
		$password = "usg7zl5rJbH5";
		$dbname = "epiz_32422288_dashboardapp";

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