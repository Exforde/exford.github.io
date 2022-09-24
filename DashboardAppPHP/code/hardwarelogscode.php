<?php 

    // Get Actual Columnname based on the index found in front-end table (used for sorting)
	function GetHardwareLogsColumnByIndex($colindex) {
		switch($colindex) {
			case 0: return "HL.HARDWARELOGKEY";
			case 1: return "H.HARDWARENAME";
			case 2: return "P.PLANTKEY";
			case 3: return "HL.TEMPERATURE";
			case 4: return "HL.HUMIDITY";
			case 5: return "PS.STATUSNAME";
			case 6: return "HL.CREATEDDATE";
			default: return "HARDWARELOGKEY";
		}
	}

	function GetHardwareLogs($conn, $col = 'HARDWARELOGKEY', $order = 'DESC', $offset = 0) {

		$sql = "
			SELECT
				HL.HARDWARELOGKEY,
				H.HARDWAREKEY,
				H.HARDWARENAME,
				P.PLANTKEY,
				P.PLANTNAME,
				HL.TEMPERATURE,
				HL.HUMIDITY,
				PS.PLANTSTATUSKEY,
				PS.STATUSNAME,
				PS.STATUSCOLOR,
				HL.CREATEDBY,
				HL.CREATEDDATE
			FROM HARDWARELOGS HL
			LEFT JOIN HARDWARE H ON H.HARDWAREKEY = HL.HARDWAREKEY
			LEFT JOIN PLANTS P ON P.PLANTKEY = HL.PLANTKEY
			LEFT JOIN PLANTSTATUS PS ON PS.PLANTSTATUSKEY = HL.PLANTSTATUSKEY
		";

		$sql .= "ORDER BY ".$col." ".$order." ";
		$sql .= "LIMIT 5 OFFSET ".$offset.";";

		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		return $result;
	}

	function GetHardwareLogsTotal($conn) {

		$sql = "SELECT COUNT(*) FROM HARDWARELOGS";
		$count = $conn->query($sql)->fetch_row()[0];
		return $count;
	}

    function InsertHardwareLogs($conn, $data) {

        $sql = "INSERT INTO HARDWARELOGS (HARDWAREKEY, PLANTKEY, TEMPERATURE, HUMIDITY, PLANTSTATUSKEY, CREATEDBY, CREATEDDATE, ACTIVEFLAG) VALUES(?, ?, ?, ?, ?,'System',NOW(), 'Y')";
		$stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiii", $data->HARDWAREKEY, $data->PLANTKEY, $data->TEMPERATURE, $data->HUMIDITY, $data->PLANTSTATUSKEY);
        $stmt->execute();
    }

?>