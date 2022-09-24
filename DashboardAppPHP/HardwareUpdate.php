<?php 
    require __DIR__ . '/code/dbcode.php';
    require __DIR__ . '/code/hardwarecode.php';
    require __DIR__ . '/code/plantcode.php';

    $conn = dbconnect();
    $hardware = GetHardware($conn, $_GET['key']);
    $hardwareData = $hardware->fetch_assoc();
    $hardwareType = GetHardwareType($conn, NULL, 'HT.HARDWARETYPEKEY', 'DESC', 0, NULL);
    $plant = GetPlant($conn, NULL, 'P.PLANTKEY', 'DESC', 0, NULL);
    $conn->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard - Hardware Update</title>
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/utils.css">
        <link rel="stylesheet" href="css/all.min.css">
        <script src="script/main.js"></script>
    </head>

    <body>
        <div id="sidebar">
            <div id="site-title">Dashboard App</div>
            <div id="side-controls">
                <a href="/DashboardAppPHP" class="side-item" onmouseover="sidebarHover(this)" onmouseout="sidebarHoverOut(this)"><span class="fa fa-list"></span><span>Data Tracker</span></a>
                <a href="/DashboardAppPHP/PlantManagement.php" class="side-item" onmouseover="sidebarHover(this)" onmouseout="sidebarHoverOut(this)"><span class="fa fa-seedling"></span><span>Plant Management</span></a>
                <a href="/DashboardAppPHP/HardwareManagement.php" class="side-item active" onmouseover="sidebarHover(this)" onmouseout="sidebarHoverOut(this)"><span class="fa fa-hard-drive"></span><span>Hardware Management</span></a>
                <!-- <a href="#" class="side-item" onmouseover="sidebarHover(this)" onmouseout="sidebarHoverOut(this)"><span class="fa fa-cog"></span><span>Settings</span></a> -->
            </div>
        </div>
        <div id="content">

            <div id="content-header">
                <h1>Hardware Management</h3>
            </div>

            <div id="content-body">

                <div class="box">
                    <div class="box-header">
                        <h3>HARDWARE UPDATE</h1>
                    </div>
                    <div class="box-body">
                        <form action="/DashboardAppPHP/FormUpdateHardware.php" method="POST">
                            <div class="form-item">
                                <div class="info-left">Id:</div>
                                <div class="info-right"><?php echo $hardwareData['HARDWAREKEY'] ?></div>
                                <input type="number" value="<?php echo $hardwareData['HARDWAREKEY'] ?>" name="hardwareKey" hidden readonly />
                            </div>
                            <div class="form-item">
                                <div class="info-left">Unique Id:</div>
                                <div class="info-right"><?php echo $hardwareData['UNIQUEID'] ?></div>
                            </div>
                            <div class="form-item">
                                <div class="info-left">Hardware Name:</div>
                                <div class="info-right"><input type="text" value="<?php echo $hardwareData['HARDWARENAME'] ?>" name="hardwareName" /></div>
                            </div>
                            <div class="form-item">
                                <div class="info-left">Hardware Type:</div>
                                <div class="info-right">
                                    <select name="hardwareType">
                                        <option disabled selected>-- Select Hardware Type --</option>
                                        <?php if(mysqli_num_rows($hardwareType) > 0) { ?>
                                            <?php while($row = $hardwareType->fetch_assoc()) { ?>
                                                <option value="<?php echo $row['HARDWARETYPEKEY'] ?>" <?php if ($row['HARDWARETYPEKEY'] == $hardwareData['HARDWARETYPEKEY']) { echo "selected"; } ?> ><?php echo $row['TYPENAME'] ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-item">
                                <div class="info-left">Tracking Plant:</div>
                                <div class="info-right">
                                    <select name="plantKey">
                                        <option disabled selected>-- Select Plant --</option>
                                        <?php if(mysqli_num_rows($plant) > 0) { ?>
                                            <?php while($row = $plant->fetch_assoc()) { ?>
                                                <option value="<?php echo $row['PLANTKEY'] ?>" <?php if ($row['PLANTKEY'] == $hardwareData['TRACKINGPLANTKEY']) { echo "selected"; } ?> ><?php echo $row['PLANTNAME'] ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-item">
                                <div class="info-left">Status:</div>
                                <div class="info-right"><?php echo "<span class='fa fa-circle' style='color:".$hardwareData['HARDWARESTATUSCOLOR'].";margin-right:5px;'></span>".$hardwareData['HARDWARESTATUS']  ?></div>
                            </div>
                            <div class="form-item">
                                <div class="info-left">Active Flag:</div>
                                <div class="info-right">
                                    <select name="hardwareActiveFlag">
                                        <option value="Y" <?php if($hardwareData['ACTIVEFLAG'] == "Y") { echo "selected"; } ?>>Enabled</option>
                                        <option value="N" <?php if($hardwareData['ACTIVEFLAG'] == "N") { echo "selected"; } ?>>Disabled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-item">
                                <a href="/DashboardAppPHP/HardwareManagement.php" class="btn btn-danger-outline" type="submit" style="width: 150px; margin-top: 10px; margin-right: 10px; padding: 10px 0;">Cancel</a>
                                <button class="btn btn-default" type="submit" style="width: 150px; margin-top: 10px;">Update Hardware</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </body>
    <script>
        
    </script>
</html>