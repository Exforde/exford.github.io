<?php 

    // Get Actual Columnname based on the index found in front-end table (used for sorting)
	function GetPlantColumnByIndex($colindex) {
		switch($colindex) {
			case 0: return "PLANTKEY";
			case 1: return "PLANTNAME";
			case 2: return "PT.TYPENAME";
			case 5: return "P.CREATEDBY";
			case 6: return "P.CREATEDDATE";
			case 7: return "P.UPDATEDBY";
			case 8: return "P.UPDATEDDATE";
			case 9: return "P.ACTIVEFLAG";
			default: return "PLANTKEY";
		}
	}

    // Retreival for Plant
    function GetPlant($conn, $key = NULL, $col = 'P.PLANTKEY', $order = 'DESC', $offset = 0, $limit = 5) {

        $sql = "
            SELECT
                P.PLANTKEY,
                P.PLANTNAME,
                PT.PLANTTYPEKEY,
                PT.TYPENAME AS PLANTTYPENAME,
                P.CREATEDBY,
                P.CREATEDDATE,
                P.UPDATEDBY,
                P.UPDATEDDATE,
                P.ACTIVEFLAG
            FROM PLANTS P
            LEFT JOIN PLANTTYPE PT ON PT.PLANTTYPEKEY = P.PLANTTYPEKEY
        ";

        // Construct WHERE clause if filters are available
        $a_where = array(); // Temporary container to store each where conditions
        $a_type = array(); // Temporary container to store datatype used for bind param parameter
        $a_vals = array(); // Temporary container to store the actual value to be used for bind param
        $a_param = array(); // Container for the complete bind param data
        $where = NULL; // Container for the complete WHERE clause

        // Check key, if exists create WHERE for key
        if (!is_null($key)) {
            $a_where[] = "(P.PLANTKEY = ?)";
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

	function GetPlantTotal($conn) {

		$sql = "SELECT COUNT(*) FROM PLANTS";
		$count = $conn->query($sql)->fetch_row()[0];
		return $count;
	}

    function InsertPlant($conn, $data) {

        $sql = "INSERT INTO PLANTS (PLANTNAME, PLANTTYPEKEY, CREATEDBY, CREATEDDATE, ACTIVEFLAG) VALUES(?, ?,'System',NOW(), 'Y')";
		$stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $data->PLANTNAME, $data->PLANTTYPEKEY);
        $stmt->execute();
    }

    function UpdatePlant($conn, $data) {
        
        $a_type = array();
        $a_vals = array();
        $a_param = array();
        
        $sql = "UPDATE PLANTS SET ";

        // Dynamic Data Values
        $count = 0;
        foreach($data as $key => $val) {
            if ($key != "PLANTKEY") {
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
        $sql .= " WHERE PLANTKEY = ?";
        $a_type[] = 'i';
        $a_vals[] = $data->PLANTKEY;

        echo $sql;
		$stmt = $conn->prepare($sql);
        $a_param[] = implode("", $a_type);
        $a_param = array_merge($a_param, $a_vals);
        call_user_func_array(array($stmt, 'bind_param'), $a_param);
        $stmt->execute();
    }

    // Get Actual Columnname based on the index found in front-end table (used for sorting)
	function GetPlantTypeColumnByIndex($colindex) {
		switch($colindex) {
			case 0: return "PLANTTYPEKEY";
			case 1: return "TYPENAME";
			case 2: return "CREATEDDATE";
			case 3: return "UPDATEDDATE";
			default: return "PLANTTYPEKEY";
		}
	}

    function GetPlantType($conn, $key = NULL, $col = 'PLANTTYPEKEY', $order = 'DESC', $offset = 0) {

        $sql = "
            SELECT
                PLANTTYPEKEY,
                TYPENAME,
                CREATEDBY,
                CREATEDDATE,
                UPDATEDBY,
                UPDATEDDATE,
                ACTIVEFLAG
            FROM PLANTTYPE
        ";

        // Construct WHERE clause if filters are available
        $a_where = array(); // Temporary container to store each where conditions
        $a_type = array(); // Temporary container to store datatype used for bind param parameter
        $a_vals = array(); // Temporary container to store the actual value to be used for bind param
        $a_param = array(); // Container for the complete bind param data
        $where = NULL; // Container for the complete WHERE clause

        // Check key, if exists create WHERE for key
        if (!is_null($key)) {
            $a_where[] = "(PLANTTYPEKEY = ?)";
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
        $sql .= "LIMIT 5 OFFSET ".$offset.";";
        
		$stmt = $conn->prepare($sql);
        if (count($a_where) > 0) {
            call_user_func_array(array($stmt, 'bind_param'), $a_param);
        }
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
        return $result;
    }

	function GetPlantTypeTotal($conn) {

		$sql = "SELECT COUNT(*) FROM PLANTTYPE";
		$count = $conn->query($sql)->fetch_row()[0];
		return $count;
	}

    function InsertPlantType($conn, $data) {

        $sql = "INSERT INTO PLANTTYPE (TYPENAME, CREATEDBY, CREATEDDATE, ACTIVEFLAG) VALUES(?, 'System',NOW(), 'Y')";
		$stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $data->TYPENAME);
        $stmt->execute();
    }

    function UpdatePlantType($conn, $data) {
        
        $a_type = array();
        $a_vals = array();
        $a_param = array();
        
        $sql = "UPDATE PLANTTYPE SET ";

        // Dynamic Data Values
        $count = 0;
        foreach($data as $key => $val) {
            if ($key != "PLANTTYPEKEY") {
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
        $sql .= " WHERE PLANTTYPEKEY = ?";
        $a_type[] = 'i';
        $a_vals[] = $data->PLANTTYPEKEY;

        echo $sql;
		$stmt = $conn->prepare($sql);
        $a_param[] = implode("", $a_type);
        $a_param = array_merge($a_param, $a_vals);
        call_user_func_array(array($stmt, 'bind_param'), $a_param);
        $stmt->execute();
    }

?>