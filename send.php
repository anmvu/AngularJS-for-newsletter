<?php 
	$data = json_decode(file_get_contents('php://input'));
	// $data = file_get_contents('php//input');
	
	print_r($data);
	$link = mysql_connect("127.0.0.1","an","Mws9ZhWqfZvpZfnJ");
	mysql_select_db("an");
	
	$query = sprintf("INSERT INTO NEWSLETTER (ID,JSON) VALUES (\"%d\",\"%s\")",2,$data);
	print_r($query);
	$res = mysql_query($query);
?>
