<?php 
    require __DIR__ . '/code/dbcode.php';
    require __DIR__ . '/code/PlantCode.php';
    require __DIR__ . '/code/pagehandler.php';
    require __DIR__ . '/code/utilscode.php';

    $err = NULL;
    if (!isset($_POST['typeName'])) {
        $err .= "typeName";
    }
    if (!is_null($err)) {
        redirectToPage('PlantTypeAdd.php?error='.$err);
    }

    $data = new stdClass();
    $data->TYPENAME = $_POST['typeName'];
    
    $conn = dbconnect();
    InsertPlantType($conn, $data);

    redirectToPage('PlantManagement.php?&scmsg=Plant Type has been added');
?>