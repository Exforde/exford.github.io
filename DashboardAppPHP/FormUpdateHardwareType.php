<?php 
    require __DIR__ . '/code/dbcode.php';
    require __DIR__ . '/code/hardwarecode.php';
    require __DIR__ . '/code/pagehandler.php';
    require __DIR__ . '/code/utilscode.php';

    $err = NULL;
    if (!isset($_POST['hardwareTypeKey'])) {
        $err .= "hardwareTypeKey";
    }
    if (!isset($_POST['typeName'])) {
        if (!is_null($err)) { $err .= ","; }
        $err .= "typeName";
    }
    if (!is_null($err)) {
        redirectToPage('HardwareTypeUpdate.php?key='.$_POST['hardwareKey'].'&error='.$err);
    }

    $data = new stdClass();
    $data->HARDWARETYPEKEY = $_POST['hardwareTypeKey'];
    $data->TYPENAME = $_POST['typeName'];
    
    $conn = dbconnect();
    UpdateHardwareType($conn, $data);

    redirectToPage('HardwareManagement.php?&scmsg=Hardware has been updated');
?>