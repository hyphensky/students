<?php
require "../header.php";
$st_per_page = 50;
$s_string = "";
$pages = 0;
$search = '';

function make_sort_link($title, $asc, $desc) {
	$sort = $_GET['sort'] ?? "points_desc";
 
	if ($sort == $asc) {
		return '<a class="active" href="?sort=' . html($desc) . '">' . html($title) . ' <i>▲</i></a>';
	} elseif ($sort == $desc) {
		return '<a class="active" href="?sort=' . html($asc) . '">' . html($title) . ' <i>▼</i></a>';  
	} else {
		return '<a href="?sort=' . html($asc) . '">' . html($title) . '</a>';  
	}
}
$page =  isset(($_GET['page'])) ? intval($_GET['page']) : 1;
$stgw = new StudentGateway();
if ($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['search'])) {
    $search = $_GET['search'];
	$result = $stgw->getSearchItems($pdo, $search);
} else {
	$sort = $_GET['sort'] ?? "points_desc";
	$result = $stgw->getAllStudents($pdo, $st_per_page, $sort, $page);
	$pages = ceil($stgw->getStudentCount($pdo) / $st_per_page);
}

include '../views/index.phtml';