<?php 
	require_once '../../config.php';

	$link_id = $_SERVER[REQUEST_URI];

	$id = preg_match('/([0-9]+)/',$link_id, $matches);
		
	$query = mysql_query(sprintf("SELECT TITLE, JSON FROM NEWSLETTER WHERE ID = '%s'",$matches[0]));

	$row = mysql_fetch_row($query);

	
	//$row[1] = json_decode($row[1]);
	$row[1] = str_replace('&nbsp;', ' ', $row[1]);

	echo json_encode($row);
	//print_r($json_response);
?>