<?php 
    require __DIR__ . '/code/dbcode.php';
    require __DIR__ . '/code/hardwarelogscode.php';

    $conn = dbconnect();
    $hardwarelogs = GetHardwareLogs($conn);
    $hardwarelogsTotal = GetHardwareLogsTotal($conn);
    $hardwarelogspages = ceil($hardwarelogsTotal / 5);
    $conn->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/utils.css">
        <link rel="stylesheet" href="css/all.min.css">
        <script src="script/main.js"></script>
    </head>

    <body>
        <div id="sidebar">
            <div id="site-title">Dashboard App</div>
            <div id="side-controls">
                <a href="/DashboardAppPHP" class="side-item active" onmouseover="sidebarHover(this)" onmouseout="sidebarHoverOut(this)"><span class="fa fa-list"></span><span>Data Tracker</span></a>
                <a href="/DashboardAppPHP/PlantManagement.php" class="side-item" onmouseover="sidebarHover(this)" onmouseout="sidebarHoverOut(this)"><span class="fa fa-seedling"></span><span>Plant Management</span></a>
                <a href="/DashboardAppPHP/HardwareManagement.php" class="side-item" onmouseover="sidebarHover(this)" onmouseout="sidebarHoverOut(this)"><span class="fa fa-hard-drive"></span><span>Hardware Management</span></a>
                <!-- <a href="#" class="side-item" onmouseover="sidebarHover(this)" onmouseout="sidebarHoverOut(this)"><span class="fa fa-cog"></span><span>Settings</span></a> -->
            </div>
        </div>
        <div id="content">

            <div id="content-header">
                <h1>Data Tracker</h3>
            </div>

            <div id="content-body">

                <div id="box-hardwarelogs" class="box">
                    <div class="box-header">
                        <h3>HARDWARE LOGS</h1>
                    </div>
                    <div class="box-body">
                        <table id="tbl-hardwarelogs">
                            <thead>
                                <tr>
                                    <th data-colindex="0" data-orderdir="0" onclick="sortTable(this)">Log ID<span class="fa fa-caret-down"></span></th>
                                    <th data-colindex="1" data-orderdir="0" onclick="sortTable(this)">Hardware<span class="fa fa-caret-down"></span></th>
                                    <th data-colindex="2" data-orderdir="0" onclick="sortTable(this)">Plant Tracking<span class="fa fa-caret-down"></span></th>
                                    <th data-colindex="3" data-orderdir="0" onclick="sortTable(this)">Temperature<span class="fa fa-caret-down"></span></th>
                                    <th data-colindex="4" data-orderdir="0" onclick="sortTable(this)">Humidity<span class="fa fa-caret-down"></span></th>
                                    <th data-colindex="5" data-orderdir="0" onclick="sortTable(this)">Plant Status<span class="fa fa-caret-down"></span></th>
                                    <th data-colindex="6" data-orderdir="0" onclick="sortTable(this)">Datetime<span class="fa fa-caret-down"></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($hardwarelogs) == 0) { ?>
                                    <tr><td class="text-center" colspan="7">No Data Found</td></tr>
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
                            </tbody>
                        </table>
                        <div class="pagination nearstart" data-maxpages="<?php echo $hardwarelogspages; ?>">
                            <button class="btn btn-default btn-prev" onclick="paginateTable(this)" disabled>Prev</button>
                                <span class="page-buttons">
                                <?php for($x = 1; $x <= $hardwarelogspages; $x++) { ?>
                                    <?php if ($x >= 5) {  ?>
                                        <button class="btn btn-default" disabled>...</button>
                                    <?php break; } ?>
                                    <button class="btn btn-default btn-page <?php echo ($x == 1) ? "active" : ""; ?>" data-page="<?php echo $x; ?>" onclick="paginateTable(this)"><?php echo $x; ?></button>
                                <?php } ?>
                                </span>
                            <button class="btn btn-default btn-next" <?php echo ($hardwarelogspages <= 1) ? "disabled" : 'data-page="2" onclick="paginateTable(this)"'; ?>>Next</button>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
    </body>
    <script>
        function sortTable($elem) {

            let $tblEl = getParentElement($elem, 'table');
            let orderdir = ($elem.getAttribute('data-orderdir') == 0) ? 1 : 0;
            let data = "colindex=" + $elem.getAttribute('data-colindex') + "&orderdir=" + orderdir + "&page=1";
            executeAjaxPOSTRequest("AjaxUpdateHardwareLogs.php", data, (res) => { tblSortCommand($tblEl, $elem, orderdir, res); });
        }

        function paginateTable($elem) {
            
            let $container = getParentElementById($elem, 'box-hardwarelogs');
            let $pagination = getParentElementByClass($elem, 'pagination');
            let $page = $elem.getAttribute('data-page');
            let $tblEl = $container.querySelector('#tbl-hardwarelogs');
            let orderdir = $tblEl.querySelector('th').getAttribute('data-orderdir');
            let colindex = $tblEl.querySelector('th').getAttribute('data-colindex');
            if ($tblEl.querySelector('th[data-orderdir="1"]')) {
                orderdir = $tblEl.querySelector('th[data-orderdir="1"]').getAttribute('data-orderdir');
                colindex = $tblEl.querySelector('th[data-orderdir="1"]').getAttribute('data-colindex');
            }
            let data = "colindex=" + colindex + "&orderdir=" + orderdir + "&page=" + $elem.getAttribute('data-page');
            executeAjaxPOSTRequest("AjaxUpdateHardwareLogs.php", data, (res) => { tblPagination($tblEl, $page, $pagination, res) } );
        }
    </script>
</html>