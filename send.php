<?php 

	require_once '../../config.php';
	// $data = json_decode(file_get_contents('php://input'));
	$data = file_get_contents('php://input');
	print_r($data);
	
	$regex = preg_match('/(^.*)&title:(.*)&JSON:(.*)/',$data,$matches);

	$json = mysql_real_escape_string($matches[3]);

	// $find = mysql_query(sprintf("SELECT * FROM NEWSLETTER WHERE TITLE=\"%s\"",$matches[1]));

	// $row = mysql_fetch_row($find);

	if($matches[1]=="none"){
		print_r('no id!');
		$id_query = mysql_query("SELECT ID FROM NEWSLETTER ORDER BY ID DESC LIMIT 1");
		$id_find = mysql_result($id_query,0);
		$id = (int)$id_find;
		$id++;
		$query = sprintf("INSERT INTO NEWSLETTER (ID,TITLE,JSON) VALUES (\"%d\",\"%s\",\"%s\")",$id,$matches[2],$json);
	}
	else{
		echo $matches[1];
		$query = sprintf("UPDATE NEWSLETTER SET TITLE= '%s',JSON='%s' WHERE ID='%d'",$matches[2],$json,$matches[1]);
	}
	print_r($query);
	$res = mysql_query($query);
?>