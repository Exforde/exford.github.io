<?php 
    require __DIR__ . '/code/dbcode.php';
    require __DIR__ . '/code/PlantCode.php';
    require __DIR__ . '/code/pagehandler.php';
    require __DIR__ . '/code/utilscode.php';

    $err = NULL;
    if (!isset($_POST['plantName'])) {
        $err .= "plantName";
    }
    if (!isset($_POST['plantType'])) {
        $err .= "plantType";
    }
    if (!is_null($err)) {
        redirectToPage('PlantAdd.php?error='.$err);
    }

    $data = new stdClass();
    $data->PLANTNAME = $_POST['plantName'];
    $data->PLANTTYPEKEY = $_POST['plantType'];
    
    $conn = dbconnect();
    InsertPlant($conn, $data);

    redirectToPage('PlantManagement.php?&scmsg=Plant has been added');
?>