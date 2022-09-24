<?php 
    require __DIR__ . '/code/pagehandler.php';
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        redirectError401();
    }

    require __DIR__ . '/code/dbcode.php';
    require __DIR__ . '/code/hardwarecode.php';

    $conn = dbconnect();
    $colindex = $_POST['colindex'];
    $orderdir = $_POST['orderdir'];
    $offset = ($_POST['page'] - 1) * 5;
    $hardware = GetHardware($conn, NULL, NULL, GetHardwareColumnByIndex($colindex), GetColumnOrder($orderdir), $offset);
    $conn->close();
?>

<?php if(mysqli_num_rows($hardware) == 0) { ?>
    <tr><td class="text-center" colspan="7">No Data Found<td></tr>
<?php } else { ?>
    <?php while($row = $hardware->fetch_assoc()) { ?>
        <tr>
            <td>
            <a href="/DashboardAppPHP/HardwareUpdate.php?key=<?php echo $row['HARDWAREKEY'] ?>" class="btn btn-default"><span class="fa fa-edit"></span></a>
            </td>
            <td><?php echo $row['HARDWAREKEY'] ?></td>
            <td><?php echo $row['UNIQUEID'] ?></td>
            <td><?php echo $row['HARDWARENAME'] ?></td>
            <td><?php echo $row['HARDWARETYPENAME'] ?></td>
            <td><?php echo "<span class='fa fa-circle' style='color:".$row['HARDWARESTATUSCOLOR'].";margin-right:5px;'></span>".$row['HARDWARESTATUS']  ?></td>
            <td><?php echo date("F jS, Y", strtotime($row['CREATEDDATE'])) ?></td>
            <td><?php echo ($row['UPDATEDDATE']) ? date("F jS, Y", strtotime($row['UPDATEDDATE'])) : "--" ?></td>
            <td><?php echo ($row['ACTIVEFLAG'] == 'Y') ? "<span class='badge bg-green text-white'>Enabled</span>" : "<span class='badge bg-red text-white'>Disabled</span>" ?></td>
        </tr>
    <?php } ?>
<?php } ?>