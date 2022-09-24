<?php 
    require __DIR__ . '/code/dbcode.php';
    require __DIR__ . '/code/hardwarecode.php';
    require __DIR__ . '/code/pagehandler.php';
    require __DIR__ . '/code/utilscode.php';

    $err = NULL;
    if (!isset($_POST['hardwareKey'])) {
        $err .= "hardwareKey";
    }
    if (!isset($_POST['hardwareName'])) {
        if (!is_null($err)) { $err .= ","; }
        $err .= "hardwareName";
    }
    if (!isset($_POST['hardwareType'])) {
        if (!is_null($err)) { $err .= ","; }
        $err .= "hardwareType";
    }
    if (!isset($_POST['plantKey'])) {
        if (!is_null($err)) { $err .= ","; }
        $err .= "plantKey";
    }
    if (!isset($_POST['hardwareActiveFlag'])) {
        if (!is_null($err)) { $err .= ","; }
        $err .= "hardwareActiveFlag";
    }
    if (!is_null($err)) {
        redirectToPage('HardwareUpdate.php?key='.$_POST['hardwareKey'].'&error='.$err);
    }

    $data = new stdClass();
    $data->HARDWAREKEY = $_POST['hardwareKey'];
    $data->HARDWARENAME = $_POST['hardwareName'];
    $data->HARDWARETYPEKEY = $_POST['hardwareType'];
    $data->TRACKINGPLANTKEY = $_POST['plantKey'];
    $data->ACTIVEFLAG = $_POST['hardwareActiveFlag'];
    
    $conn = dbconnect();
    UpdateHardware($conn, $data);

    redirectToPage('HardwareManagement.php?&scmsg=Hardware has been updated');
?>