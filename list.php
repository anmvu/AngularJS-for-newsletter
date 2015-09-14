<?php 
	$link = mysql_connect("localhost","an","Mws9ZhWqfZvpZfnJ");
	mysql_select_db("an");
	
	$query = mysql_query("SELECT ID, TITLE FROM NEWSLETTER");
	
	$line = "<head><title>Newsletter</title><div id=\"index\"><link href=\"css/index.css\" rel=\"stylesheet\"></head><div class=\"header\"><img src=\"https://ci4.googleusercontent.com/proxy/J5H7s6ByCuKyEi34upkJjSoIC-5-76F4p9JMauXj1ttM73u1X0cECHTls1GpGiqEixhRW8iQ7YsPLhEjGU8Dz5Jiyw7aDtGTHJSm5ZdPcEoybuXTQ6iUoWkF2yw6Qd8eYsRbTQKKPxHabdLU=s0-d-e1-ft#http://research.poly.edu/~emailmarket/admin/temp/templates/20/nyu_engineering_logo.png\" width=\"223\" height=\"30\" alt=\"nyu_engineering_logo.png\" title=\"nyu_engineering_logo.png\" class=\"headr-img\"></div><div class=\"menu-wrap\"><nav class=\"menu\"><ul class=\"clearfix\"><li id=\"new\"><a href=\"#\">New</a></li><li id = \"open\"><a href=\"#\">Open</a><ul class=\"open\" name=\"newsletters\"><table><tbody>";

	while ($row = mysql_fetch_row($query)){
		// print_r($row);
		$title = $row[1];
		$id = $row[0];
		$line .= "<tr><td>".$title."</td><td><a href=\"viewer.php?=".$id."\">View</a></td><td><a href=\"editor.php?=".$id."\">Edit</a></td></tr>";
	}

	$line .= "</tbody></table></ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</body>
</html>";
	echo $line;
?>