<?php 
    require __DIR__ . '/code/pagehandler.php';
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        redirectError401();
    }

    require __DIR__ . '/code/dbcode.php';
    require __DIR__ . '/code/hardwarelogscode.php';

    $conn = dbconnect();
    $colindex = $_POST['colindex'];
    $orderdir = $_POST['orderdir'];
    $offset = ($_POST['page'] - 1) * 5;
    $hardwarelogs = GetHardwareLogs($conn, GetHardwareLogsColumnByIndex($colindex), GetColumnOrder($orderdir), $offset);
    $conn->close();
?>

<?php if(mysqli_num_rows($hardwarelogs) == 0) { ?>
    <tr><td class="text-center" colspan="7">No Data Found<td></tr>
<?php } else { ?>
    <?php while($row = $hardwarelogs->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['HARDWARELOGKEY'] ?></td>
            <td><?php echo $row['HARDWARENAME'] ?></td>
            <td><?php echo $row['PLANTNAME'] ?></td>
            <td><?php echo $row['TEMPERATURE'] ?></td>
            <td><?php echo $row['HUMIDITY'] ?></td>
            <td><?php echo $row['STATUSNAME'] ?></td>
            <td><?php echo date("F jS, Y - h:i:s A", strtotime($row['CREATEDDATE'])) ?></td>
        </tr>
    <?php } ?>
<?php } ?>