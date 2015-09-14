<?php 
	$link = mysql_connect("localhost","an","Mws9ZhWqfZvpZfnJ");
	mysql_select_db("an");

	$link_id = file_get_contents('php://input');

	echo $link_id;

	$id = preg_match('/([0-9]+)/',$link_id, $matches);
	
	$query = mysql_query(sprintf("SELECT TITLE, JSON FROM NEWSLETTER WHERE ID = '%s'",$id));
	
	// echo json_encode($matches[2]);
	// echo json_encode($matches);
?>