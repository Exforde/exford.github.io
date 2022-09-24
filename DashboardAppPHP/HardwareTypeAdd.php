<?php 
    
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
                        <h3>HARDWARE TYPE ADD</h1>
                    </div>
                    <div class="box-body">
                        <form action="/DashboardAppPHP/FormAddHardwareType.php" method="POST">
                            <div class="form-item">
                                <div class="info-left">Hardware Type Name:</div>
                                <div class="info-right"><input type="text" name="typeName" /></div>
                            </div>
                            <div class="form-item">
                                <a href="/DashboardAppPHP/HardwareManagement.php" class="btn btn-danger-outline" type="submit" style="width: 150px; margin-top: 10px; margin-right: 10px; padding: 10px 0;">Cancel</a>
                                <button class="btn btn-default" type="submit" style="width: 150px; margin-top: 10px;">Add Type</button>
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