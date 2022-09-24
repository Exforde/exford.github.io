<?php 

    // Get Actual Columnname based on the index found in front-end table (used for sorting)
	function GetHardwareColumnByIndex($colindex) {
		switch($colindex) {
			case 0: return "HARDWAREKEY";
			case 1: return "UNIQUEID";
			case 2: return "HARDWARENAME";
			case 3: return "HT.TYPENAME";
			case 4: return "HS.STATUSNAME";
			case 5: return "P.PLANTNAME";
			case 6: return "H.CREATEDBY";
			case 7: return "H.CREATEDDATE";
			case 8: return "H.UPDATEDBY";
			case 9: return "H.UPDATEDDATE";
			case 10: return "H.ACTIVEFLAG";
			default: return "HARDWAREKEY";
		}
	}

    // Retreival for Hardware
    function GetHardware($conn, $key = NULL, $uid = NULL, $col = 'H.HARDWAREKEY', $order = 'DESC', $offset = 0, $limit = 5) {

        $sql = "
            SELECT
                H.HARDWAREKEY,
                H.UNIQUEID,
                H.HARDWARENAME,
                HT.HARDWARETYPEKEY,
                HT.TYPENAME AS HARDWARETYPENAME,
                HS.HARDWARESTATUSKEY,
                HS.STATUSNAME AS HARDWARESTATUS,
                HS.STATUSCOLOR AS HARDWARESTATUSCOLOR,
                P.PLANTKEY AS TRACKINGPLANTKEY,
                P.PLANTNAME,
                H.CREATEDBY,
                H.CREATEDDATE,
                H.UPDATEDBY,
                H.UPDATEDDATE,
                H.ACTIVEFLAG
            FROM HARDWARE H
            LEFT JOIN HARDWARETYPE HT ON HT.HARDWARETYPEKEY = H.HARDWARETYPEKEY
            LEFT JOIN HARDWARESTATUS HS ON HS.HARDWARESTATUSKEY = H.HARDWARESTATUSKEY
            LEFT JOIN PLANTS P ON P.PLANTKEY = H.TRACKINGPLANTKEY
        ";

        // Construct WHERE clause if filters are available
        $a_where = array(); // Temporary container to store each where conditions
        $a_type = array(); // Temporary container to store datatype used for bind param parameter
        $a_vals = array(); // Temporary container to store the actual value to be used for bind param
        $a_param = array(); // Container for the complete bind param data
        $where = NULL; // Container for the complete WHERE clause

        // Check key, if exists create WHERE for key
        if (!is_null($key)) {
            $a_where[] = "(H.HARDWAREKEY = ?)";
            $a_type[] = 'i';
            $a_vals[] = &$key;
        }
        // Check uid, if exists create WHERE for uid
        if (!is_null($uid)) {
            $a_where[] = "(H.UNIQUEID = ?) ";
            $a_type[] = 's';
            $a_vals[] = &$uid;
        }
        // Check if there is Temporary WHERE container has value, if yes
        if (count($a_where) > 0) {
            $sql .= "WHERE ".implode(" AND ", $a_where); // Join each where into single string separated by AND
            $a_param[] = implode("", $a_type); // Join each data type for param bind
            $a_param = array_merge($a_param, $a_vals); // Complete the param bind data
        }
        
        $sql .= "ORDER BY ".$col." ".$order." ";
        $sql .= "LIMIT ".$limit." OFFSET ".$offset.";";
        
		$stmt = $conn->prepare($sql);
        if (count($a_where) > 0) {
            call_user_func_array(array($stmt, 'bind_param'), $a_param);
        }
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
        return $result;
    }

	function GetHardwareTotal($conn) {

		$sql = "SELECT COUNT(*) FROM HARDWARE";
		$count = $conn->query($sql)->fetch_row()[0];
		return $count;
	}

    function InsertHardware($conn, $data) {

        $sql = "INSERT INTO HARDWARE (UNIQUEID, HARDWARENAME, HARDWARESTATUSKEY, CREATEDBY, CREATEDDATE, ACTIVEFLAG) VALUES(?, ?, ?,'System',NOW(), ?)";
		$stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $data->UNIQUEID, $data->HARDWARENAME, $data->HARDWARESTATUSKEY, $data->ACTIVEFLAG);
        $stmt->execute();
    }

    function UpdateHardware($conn, $data) {
        
        $a_type = array();
        $a_vals = array();
        $a_param = array();
        
        $sql = "UPDATE HARDWARE SET ";

        // Dynamic Data Values
        $count = 0;
        foreach($data as $key => $val) {
            if ($key != "HARDWAREKEY") {
                if ($count > 0) { $sql .= ","; } 
                $sql .= $key." = ?";
                $a_type[] = GetBindParamType($val);
                $a_vals[] = $val;
                $count++;
            }
        }

        // Default Values
        $sql .= ",UPDATEDBY = 'System'";
        $sql .= ",UPDATEDDATE = NOW()";
        
        // Where
        $sql .= " WHERE HARDWAREKEY = ?";
        $a_type[] = 'i';
        $a_vals[] = $data->HARDWAREKEY;

        echo $sql;
		$stmt = $conn->prepare($sql);
        $a_param[] = implode("", $a_type);
        $a_param = array_merge($a_param, $a_vals);
        call_user_func_array(array($stmt, 'bind_param'), $a_param);
        $stmt->execute();
    }

    // Get Actual Columnname based on the index found in front-end table (used for sorting)
	function GetHardwareTypeColumnByIndex($colindex) {
		switch($colindex) {
			case 0: return "HT.HARDWARETYPEKEY";
			case 1: return "HT.TYPENAME";
			case 2: return "HT.CREATEDDATE";
			case 3: return "HT.UPDATEDDATE";
			default: return "HT.HARDWARETYPEKEY";
		}
	}

    function GetHardwareType($conn, $key = NULL, $col = 'HT.HARDWARETYPEKEY', $order = 'DESC', $offset = 0, $limit = 5) {

        $sql = "
            SELECT
                HT.HARDWARETYPEKEY,
                HT.TYPENAME,
                HT.CREATEDBY,
                HT.CREATEDDATE,
                HT.UPDATEDBY,
                HT.UPDATEDDATE,
                HT.ACTIVEFLAG
            FROM HARDWARETYPE HT
        ";

        // Construct WHERE clause if filters are available
        $a_where = array(); // Temporary container to store each where conditions
        $a_type = array(); // Temporary container to store datatype used for bind param parameter
        $a_vals = array(); // Temporary container to store the actual value to be used for bind param
        $a_param = array(); // Container for the complete bind param data
        $where = NULL; // Container for the complete WHERE clause

        // Check key, if exists create WHERE for key
        if (!is_null($key)) {
            $a_where[] = "(HT.HARDWARETYPEKEY = ?)";
            $a_type[] = 'i';
            $a_vals[] = &$key;
        }
        // Check if there is Temporary WHERE container has value, if yes
        if (count($a_where) > 0) {
            $sql .= "WHERE ".implode(" AND ", $a_where); // Join each where into single string separated by AND
            $a_param[] = implode("", $a_type); // Join each data type for param bind
            $a_param = array_merge($a_param, $a_vals); // Complete the param bind data
        }
        
        $sql .= "ORDER BY ".$col." ".$order." ";
        if (!is_null($limit)) {
            $sql .= "LIMIT ".$limit." OFFSET ".$offset.";";
        }
        
		$stmt = $conn->prepare($sql);
        if (count($a_where) > 0) {
            call_user_func_array(array($stmt, 'bind_param'), $a_param);
        }
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
        return $result;
    }

	function GetHardwareTypeTotal($conn) {

		$sql = "SELECT COUNT(*) FROM HARDWARETYPE";
		$count = $conn->query($sql)->fetch_row()[0];
		return $count;
	}

    function InsertHardwareType($conn, $data) {

        $sql = "INSERT INTO HARDWARETYPE (TYPENAME, CREATEDBY, CREATEDDATE, ACTIVEFLAG) VALUES(?, 'System',NOW(), 'Y')";
		$stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $data->TYPENAME);
        $stmt->execute();
    }

    function UpdateHardwareType($conn, $data) {
        
        $a_type = array();
        $a_vals = array();
        $a_param = array();
        
        $sql = "UPDATE HARDWARETYPE SET ";

        // Dynamic Data Values
        $count = 0;
        foreach($data as $key => $val) {
            if ($key != "HARDWARETYPEKEY") {
                if ($count > 0) { $sql .= ","; } 
                $sql .= $key." = ?";
                $a_type[] = GetBindParamType($val);
                $a_vals[] = $val;
                $count++;
            }
        }

        // Default Values
        $sql .= ",UPDATEDBY = 'System'";
        $sql .= ",UPDATEDDATE = NOW()";
        
        // Where
        $sql .= " WHERE HARDWARETYPEKEY = ?";
        $a_type[] = 'i';
        $a_vals[] = $data->HARDWARETYPEKEY;

		$stmt = $conn->prepare($sql);
        $a_param[] = implode("", $a_type);
        $a_param = array_merge($a_param, $a_vals);
        call_user_func_array(array($stmt, 'bind_param'), $a_param);
        $stmt->execute();
    }

?>