<?php 
    require __DIR__ . '/code/dbcode.php';
    require __DIR__ . '/code/PlantCode.php';
    require __DIR__ . '/code/pagehandler.php';
    require __DIR__ . '/code/utilscode.php';

    $err = NULL;
    if (!isset($_POST['typeName'])) {
        $err .= "typeName";
    }
    $data = new stdClass();
    $data->PLANTTYPEKEY = $_POST['plantTypeKey'];
    $data->TYPENAME = $_POST['typeName'];
    
    $conn = dbconnect();
    UpdatePlantType($conn, $data);

    redirectToPage('PlantManagement.php?&scmsg=Plant has been added');
?>