<?php 
    require __DIR__ . '/code/dbcode.php';
    require __DIR__ . '/code/Plantcode.php';

    $conn = dbconnect();

    $Plant = GetPlant($conn);
    $PlantTotal = GetPlantTotal($conn);
    $PlantPages = ceil($PlantTotal / 5);
    
    $PlantType = GetPlantType($conn);
    $PlantTypeTotal = GetPlantTypeTotal($conn);
    $PlantTypePages = ceil($PlantTypeTotal / 5);
    $conn->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard - Plant Management</title>
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
                <a href="/DashboardAppPHP/PlantManagement.php" class="side-item active" onmouseover="sidebarHover(this)" onmouseout="sidebarHoverOut(this)"><span class="fa fa-seedling"></span><span>Plant Management</span></a>
                <a href="/DashboardAppPHP/HardwareManagement.php" class="side-item" onmouseover="sidebarHover(this)" onmouseout="sidebarHoverOut(this)"><span class="fa fa-hard-drive"></span><span>Hardware Management</span></a>
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
                        <h3>PLANT LIST</h1>
                        <a href="/DashboardAppPHP/PlantAdd.php" class="btn btn-default btn-add">Add Plant</a>
                    </div>
                    <div class="box-body">
                        <table id="tbl-Plant" data-ajaxurl="AjaxUpdatePlantList.php">
                            <thead>
                                <tr>
                                    <th class="no-pointer">Actions</th>
                                    <th data-colindex="0" data-orderdir="0" onclick="sortTable(this)">Plant ID<span class="fa fa-caret-down"></span></th>
                                    <th data-colindex="2" data-orderdir="0" onclick="sortTable(this)">Name<span class="fa fa-caret-down"></span></th>
                                    <th data-colindex="3" data-orderdir="0" onclick="sortTable(this)">Type<span class="fa fa-caret-down"></span></th>
                                    <th data-colindex="6" data-orderdir="0" onclick="sortTable(this)">Created Date<span class="fa fa-caret-down"></span></th>
                                    <th data-colindex="8" data-orderdir="0" onclick="sortTable(this)">Updated Date<span class="fa fa-caret-down"></span></th>
                                    <!-- <th data-colindex="9" data-orderdir="0" onclick="sortTable(this)">Activeflag<span class="fa fa-caret-down"></span></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($Plant) == 0) { ?>
                                    <tr><td class="text-center" colspan="7">No Data Found</td></tr>
                                <?php } else { ?>
                                    <?php while($row = $Plant->fetch_assoc()) { ?>
                                        <tr>
                                            <td>
                                                <a href="/DashboardAppPHP/PlantUpdate.php?key=<?php echo $row['PLANTKEY'] ?>" class="btn btn-default"><span class="fa fa-edit"></span></a>
                                            </td>
                                            <td><?php echo $row['PLANTKEY'] ?></td>
                                            <td><?php echo $row['PLANTNAME'] ?></td>
                                            <td><?php echo $row['PLANTTYPENAME'] ?></td>
                                            <td><?php echo date("F jS, Y", strtotime($row['CREATEDDATE'])) ?></td>
                                            <td><?php echo ($row['UPDATEDDATE']) ? date("F jS, Y", strtotime($row['UPDATEDDATE'])) : "--" ?></td>
                                            <!-- <td><?php //echo ($row['ACTIVEFLAG'] == 'Y') ? "<span class='badge bg-green text-white'>Enabled</span>" : "<span class='badge bg-red text-white'>Disabled</span>" ?></td> -->
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="pagination nearstart" data-maxpages="<?php echo $PlantPages; ?>">
                            <button class="btn btn-default btn-prev" onclick="paginateTable(this)" disabled>Prev</button>
                                <span class="page-buttons">
                                <?php for($x = 1; $x <= $PlantPages; $x++) { ?>
                                    <?php if ($x >= 5) {  ?>
                                        <button class="btn btn-default" disabled>...</button>
                                    <?php break; } ?>
                                    <button class="btn btn-default btn-page <?php echo ($x == 1) ? "active" : ""; ?>" data-page="<?php echo $x; ?>" onclick="paginateTable(this)"><?php echo $x; ?></button>
                                <?php } ?>
                                </span>
                            <button class="btn btn-default btn-next" <?php echo ($PlantPages <= 1) ? "disabled" : 'data-page="2" onclick="paginateTable(this)"'; ?>>Next</button>
                        </div>
                    </div>
                </div>
                
                <div class="box">
                    <div class="box-header">
                        <h3>PLANT TYPES</h1>
                        <a href="/DashboardAppPHP/PlantTypeAdd.php" class="btn btn-default btn-add">Add Plant Type</a>
                    </div>
                    <div class="box-body">
                        <table id="tbl-Planttype" data-ajaxurl="AjaxUpdatePlantTypeList.php">
                            <thead>
                                <tr>
                                    <th class="no-pointer">Actions</th>
                                    <th data-colindex="0" data-orderdir="0" onclick="sortTable(this)">Type ID<span class="fa fa-caret-down"></span></th>
                                    <th data-colindex="1" data-orderdir="0" onclick="sortTable(this)">Name<span class="fa fa-caret-down"></span></th>
                                    <th data-colindex="2" data-orderdir="0" onclick="sortTable(this)">Created Date<span class="fa fa-caret-down"></span></th>
                                    <th data-colindex="3" data-orderdir="0" onclick="sortTable(this)">Updated Date<span class="fa fa-caret-down"></span></th>
                                    <!-- <th data-colindex="4" data-orderdir="0" onclick="sortTable(this)">Activeflag<span class="fa fa-caret-down"></span></th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($PlantType) == 0) { ?>
                                    <tr><td class="text-center" colspan="7">No Data Found</td></tr>
                                <?php } else { ?>
                                    <?php while($row = $PlantType->fetch_assoc()) { ?>
                                        <tr>
                                            <td>
                                                <a href="/DashboardAppPHP/PlantTypeUpdate.php?key=<?php echo $row['PLANTTYPEKEY'] ?>" class="btn btn-default"><span class="fa fa-edit"></span></a>
                                            </td>
                                            <td><?php echo $row['PLANTTYPEKEY'] ?></td>
                                            <td><?php echo $row['TYPENAME'] ?></td>
                                            <td><?php echo date("F jS, Y", strtotime($row['CREATEDDATE'])) ?></td>
                                            <td><?php echo ($row['UPDATEDDATE']) ? date("F jS, Y", strtotime($row['UPDATEDDATE'])) : "--" ?></td>
                                            <!-- <td><?php //echo ($row['ACTIVEFLAG'] == 'Y') ? "<span class='badge bg-green text-white'>Enabled</span>" : "<span class='badge bg-red text-white'>Disabled</span>" ?></td> -->
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="pagination nearstart" data-maxpages="<?php echo $PlantTypePages; ?>">
                            <button class="btn btn-default btn-prev" onclick="paginateTable(this)" disabled>Prev</button>
                                <span class="page-buttons">
                                <?php for($x = 1; $x <= $PlantTypePages; $x++) { ?>
                                    <?php if ($x >= 5) {  ?>
                                        <button class="btn btn-default" disabled>...</button>
                                    <?php break; } ?>
                                    <button class="btn btn-default btn-page <?php echo ($x == 1) ? "active" : ""; ?>" data-page="<?php echo $x; ?>" onclick="paginateTable(this)"><?php echo $x; ?></button>
                                <?php } ?>
                                </span>
                            <button class="btn btn-default btn-next" <?php echo ($PlantTypePages <= 1) ? "disabled" : 'data-page="2" onclick="paginateTable(this)"'; ?>>Next</button>
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
            executeAjaxPOSTRequest($tblEl.getAttribute('data-ajaxurl'), data, (res) => { tblSortCommand($tblEl, $elem, orderdir, res); });
        }
        
        function paginateTable($elem) {
            
            let $container = getParentElementByClass($elem, 'box');
            let $pagination = getParentElementByClass($elem, 'pagination');
            let $page = $elem.getAttribute('data-page');
            let $tblEl = $container.querySelector('table');
            let orderdir = $tblEl.querySelector('th').getAttribute('data-orderdir');
            let colindex = $tblEl.querySelector('th').getAttribute('data-colindex');
            if ($tblEl.querySelector('th[data-orderdir="1"]')) {
                orderdir = $tblEl.querySelector('th[data-orderdir="1"]').getAttribute('data-orderdir');
                colindex = $tblEl.querySelector('th[data-orderdir="1"]').getAttribute('data-colindex');
            }
            let data = "colindex=" + colindex + "&orderdir=" + orderdir + "&page=" + $elem.getAttribute('data-page');
            executeAjaxPOSTRequest($tblEl.getAttribute('data-ajaxurl'), data, (res) => { tblPagination($tblEl, $page, $pagination, res) } );
        }
    </script>
</html>