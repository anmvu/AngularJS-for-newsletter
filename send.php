<?php 
	// $data = json_decode(file_get_contents('php://input'));
	$data = file_get_contents('php://input');
	$link = mysql_connect("127.0.0.1","an","Mws9ZhWqfZvpZfnJ");
	mysql_select_db("an");
	// print_r($data);
	$regex = preg_match('/(^.*)\s&JSON: (.*)/',$data,$matches);
	
	// $json = str_replace("\"","\\\"",$matches[2]);
	// print_r($json);
	
	$query = sprintf("INSERT INTO NEWSLETTER (ID, TITLE,JSON) VALUES (\"%d\",\"%s\",\"%s\")",1,$matches[1],mysql_real_escape_string($matches[2]));
	// print_r($query);
	$res = mysql_query($query);
?>
