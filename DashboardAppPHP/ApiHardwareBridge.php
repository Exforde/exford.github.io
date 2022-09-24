<?php

    require __DIR__ . '/code/dbcode.php';
    require __DIR__ . '/code/hardwarecode.php';
    require __DIR__ . '/code/hardwarelogscode.php';

    // $_POST = json_decode(file_get_contents("php://input"), true);
    // var_dump($_REQUEST);
    // exit();

    // Check and set data if data is existing, if not return message
    if (!isset($_GET['UNIQUEID'])) {
        echo "No data recieved.";
        exit();
    }

    $data = new stdClass();
    $data->UNIQUEID = $_GET['UNIQUEID'];
    
    // Check if unique is available in POST data recieved, if not return message
    if (!isset($data->UNIQUEID)) {
        echo "Unique Id was not found.";
        exit();
    }

    $conn = dbconnect();
        
    // Check if hardware is already in the system
    $hardware = GetHardware($conn, null, $data->UNIQUEID);
    $hardwareTotal = GetHardwareTotal($conn);
    $row = $hardware->fetch_assoc();

    if (mysqli_num_rows($hardware) == 0) { // Create hardware if not

        $data->HARDWARENAME = "Hardware Device ".$hardwareTotal+1;
        $data->HARDWARESTATUSKEY = 2;
        $data->ACTIVEFLAG = "N";
        InsertHardware($conn, $data);
        echo "Hardware has been added to system, please enable it first in the dashboard for access.";
        exit();

    } else if ($row['ACTIVEFLAG'] == 'N') { // Check if hardware is enabled
        
        echo "Hardware connected is not enabled, enable it first to save data";
        exit();
    }

    // Connected, Set and Insert Data
    $logs = new stdClass();
    $logs->HARDWAREKEY = $row['HARDWAREKEY'];
    $logs->PLANTKEY = $row['TRACKINGPLANTKEY'];
    $logs->TEMPERATURE = $_GET['TEMPERATURE'];
    $logs->HUMIDITY = $_GET["HUMIDITY"];
    $logs->PLANTSTATUSKEY = $_GET["PLANTSTATUSKEY"];
    InsertHardwareLogs($conn, $logs);
?>
