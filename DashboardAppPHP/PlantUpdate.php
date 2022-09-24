<?php 
    require __DIR__ . '/code/dbcode.php';
    require __DIR__ . '/code/plantcode.php';

    $conn = dbconnect();
    $plant = GetPlant($conn, $_GET['key']);
    $plantData = $plant->fetch_assoc();
    $plantType = GetPlantType($conn);
    $conn->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard - Plant Update</title>
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
                <h1>Plant Management</h3>
            </div>

            <div id="content-body">

                <div class="box">
                    <div class="box-header">
                        <h3>PLANT UPDATE</h1>
                    </div>
                    <div class="box-body">
                        <form action="/DashboardAppPHP/FormUpdatePlant.php" method="POST">
                            <div class="form-item">
                                <div class="info-left">Id:</div>
                                <div class="info-right"><?php echo $plantData['PLANTKEY'] ?></div>
                                <input type="number" value="<?php echo $plantData['PLANTKEY'] ?>" name="plantKey" hidden readonly />
                            </div>
                            <div class="form-item">
                                <div class="info-left">Plant Name:</div>
                                <div class="info-right"><input type="text" name="plantName" value="<?php echo $plantData['PLANTNAME'] ?>" /></div>
                            </div>
                            <div class="form-item">
                                <div class="info-left">Plant Type:</div>
                                <div class="info-right">
                                    <select name="plantType">
                                        <option disabled selected>-- Select Type --</option>
                                        <?php if(mysqli_num_rows($plantType) > 0) { ?>
                                            <?php while($row = $plantType->fetch_assoc()) { ?>
                                                <option value="<?php echo $row['PLANTTYPEKEY'] ?>" <?php if ($row['PLANTTYPEKEY'] == $plantData['PLANTTYPEKEY']) { echo "selected"; } ?>><?php echo $row['TYPENAME'] ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-item">
                                <a href="/DashboardAppPHP/PlantManagement.php" class="btn btn-danger-outline" type="submit" style="width: 150px; margin-top: 10px; margin-right: 10px; padding: 10px 0;">Cancel</a>
                                <button class="btn btn-default" type="submit" style="width: 150px; margin-top: 10px;">Update Plant</button>
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