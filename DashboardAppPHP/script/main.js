// Generic Functions
function getParentElement(htmlElementNode, target) {
    while (htmlElementNode) {
        htmlElementNode = htmlElementNode.parentNode;
        if (htmlElementNode.tagName.toLowerCase() === target) {
            return htmlElementNode;
        }
    }
    return undefined;
}

function getParentElementById(htmlElementNode, targetId) {
    while (htmlElementNode) {
        htmlElementNode = htmlElementNode.parentNode;
        if (htmlElementNode.id === targetId) {
            return htmlElementNode;
        }
    }
    return undefined;
}

function getParentElementByClass(htmlElementNode, targetClass) {
    while (htmlElementNode) {
        htmlElementNode = htmlElementNode.parentNode;
        if (htmlElementNode.classList.contains(targetClass)) {
            return htmlElementNode;
        }
    }
    return undefined;
}

// Sidebar Functions
function sidebarHover(elem) {
    elem.classList.add("hover");
}

function sidebarHoverOut(elem) {
    elem.classList.remove("hover");
}

// Ajax Functions
function executeAjaxPOSTRequest(url, data, callback) {

    let ajx = new XMLHttpRequest();
    ajx.onreadystatechange = function () {
        if (ajx.readyState == 4 && ajx.status == 200) {
            callback(ajx.responseText);
        }
    };
    ajx.open("POST", url, true);
    ajx.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajx.send(data);
}

// Table Functions
function tblReplaceContent($tblEl, res) {
    $tblEl.getElementsByTagName("tbody")[0].innerHTML = res;
}

function tblSortCommand($tblEl, $elem, orderdir, res) {
    
    tblReplaceContent($tblEl, res);
    tblResetSortIcons($tblEl);

    if (orderdir == 1) {
        $elem.setAttribute('data-orderdir', 1);
        $elem.getElementsByTagName("span")[0].classList.remove('fa-caret-down');
        $elem.getElementsByTagName("span")[0].classList.add('fa-caret-up');
    } else {
        $elem.setAttribute('data-orderdir', 0);
        $elem.getElementsByTagName("span")[0].classList.remove('fa-caret-up');
        $elem.getElementsByTagName("span")[0].classList.add('fa-caret-down');
    }
}

function tblResetSortIcons($tableEl) {

    let $thead = $tableEl.getElementsByTagName("thead")[0];
    let $th = $thead.getElementsByTagName("th");
    for(x = 0; x < $th.length; x++) {
        $th[x].setAttribute('data-orderdir', 0);
        if ($th[x].getElementsByTagName("span")[0]) {
            $th[x].getElementsByTagName("span")[0].classList.add('fa-caret-down');
            $th[x].getElementsByTagName("span")[0].classList.remove('fa-caret-up');
        }
    }
}

function tblPagination($tblEl, $page, $pagination, res) {

    tblReplaceContent($tblEl, res);
    let maxpage = parseInt($pagination.getAttribute('data-maxpages'));
    $page = parseInt($page);

    // Redraw Pages
    let redrawpages = "";
    if ($page >= 4 && (maxpage - $page) > 2) {

        $pagination.classList.remove('nearstart');
        $pagination.classList.remove('nearend');

        redrawpages = '<button class="btn btn-default" disabled>...</button> ';
        redrawpages += '<button class="btn btn-default btn-page" data-page="' + ($page - 1) + '" onclick="paginateTable(this)">' + ($page - 1) + '</button> '
        redrawpages += '<button class="btn btn-default btn-page" data-page="' + ($page) + '" onclick="paginateTable(this)">' + ($page) + '</button> '
        redrawpages += '<button class="btn btn-default btn-page" data-page="' + ($page + 1) + '" onclick="paginateTable(this)">' + ($page + 1) + '</button> '
        redrawpages += '<button class="btn btn-default" disabled>...</button>';
    }
    else if ((maxpage - $page) == 2 && maxpage > 3 && !$pagination.classList.contains('nearend')) {

        $pagination.classList.remove('nearstart');
        $pagination.classList.add('nearend');
        redrawpages = '<button class="btn btn-default" disabled>...</button> ';
        redrawpages += '<button class="btn btn-default btn-page" data-page="' + ($page - 1) + '" onclick="paginateTable(this)">' + ($page - 1) + '</button> '
        redrawpages += '<button class="btn btn-default btn-page" data-page="' + ($page) + '" onclick="paginateTable(this)">' + ($page) + '</button> '
        redrawpages += '<button class="btn btn-default btn-page" data-page="' + ($page + 1) + '" onclick="paginateTable(this)">' + ($page + 1) + '</button> '
        redrawpages += '<button class="btn btn-default btn-page" data-page="' + ($page + 2) + '" onclick="paginateTable(this)">' + ($page + 2) + '</button> '
    }
    else if ($page < 4 && !$pagination.classList.contains('nearstart')) {
        
        $pagination.classList.remove('nearend');
        $pagination.classList.add('nearstart');
        redrawpages = '<button class="btn btn-default btn-page" data-page="' + ($page - 2) + '" onclick="paginateTable(this)">' + ($page - 2) + '</button> '
        redrawpages += '<button class="btn btn-default btn-page" data-page="' + ($page - 1 ) + '" onclick="paginateTable(this)">' + ($page - 1) + '</button> '
        redrawpages += '<button class="btn btn-default btn-page" data-page="' + ($page) + '" onclick="paginateTable(this)">' + ($page) + '</button> '
        redrawpages += '<button class="btn btn-default btn-page" data-page="' + ($page + 1) + '" onclick="paginateTable(this)">' + ($page + 1) + '</button> '
        redrawpages += '<button class="btn btn-default" disabled>...</button> ';
    }

    if (redrawpages != "") { $pagination.querySelector('.page-buttons').innerHTML = redrawpages; }
    
    // Set Current Active Page
    if ($pagination.getElementsByClassName('active').length > 0) {
        $pagination.getElementsByClassName('active')[0].classList.remove('active');
    }
    $pagination.querySelector('.btn-page[data-page="' + $page + '"]').classList.add('active');

    // Previous Btn Behavior
    let prevDisable = ($page <= 1) ? true : false;
    let prevValue = ($page <= 1) ? "" : $page - 1;
    $pagination.querySelector('.btn-prev').disabled = prevDisable;
    $pagination.querySelector('.btn-prev').setAttribute('data-page', prevValue);

    // Next Btn Behavior
    let nextDisable = ($page >= maxpage || maxpage == 1) ? true : false;
    let nextValue = ($page >= maxpage || maxpage == 1) ? "" : $page + 1;
    $pagination.querySelector('.btn-next').disabled = nextDisable;
    $pagination.querySelector('.btn-next').setAttribute('data-page', nextValue);
}