<?php

	$link_id = $_SERVER[REQUEST_URI];

	$id = preg_match('/([0-9]+)/',$link_id, $matches);

	$head = "<html ng-app=\"newsApp\"><head><title>Newsletter</title><link href=\"css/news.css\"
	rel=\"stylesheet\"><link href=\"css/xeditable.css\" rel=\"stylesheet\"><link href=\"css/ng-ckeditor.css\"
	rel=\"stylesheet\"><script src=\"js/jquery.min.js\"></script><script src=\"js/angular.min.js\"></script><script
	src=\"js/jquery-ui.js\"></script><script src=\"js/angular-sanitize.min.js\"></script><script
	src=\"js/editor.js\"></script><script src=\"ckeditor/ckeditor.js\"></script><script
	src=\"js/xeditable.js\"></script><script src=\"js/ng-ckeditor.min.js\"></script><script
	src=\"js/angular-drag-and-drop-lists.js\"></script><meta http-equiv=\"Content-Type\" content=\"text/html;
	charset=UTF-8\"
	/></head></head>";

	$body_top = "<body ng-controller=\"newsController\"><div id=\"all\">";

	$notification = "<div class = \"note\" id=\"saved\">Saved!<span class=\"dismiss\"><a title=\"dismiss\" id=\"close\">
	x </a></span></div><div class = \"note \"id=\"failed\">Failed to AutoSave. Save then Refresh.<span
	class=\"dismiss\"><a title=\"dismiss\" id=\"close\"> x </a></span></div>";

	$menu_bar = "<div id=\"menu\"><div id=\"menu-bar\"><ul id=\"editor-buttons\"><li><a href=\"/~anvu/news_brief\">Main</a></li><li><a href=# id=\"export\" ng-click=\"sendJSON()\">Save</a></li><li><a
	href=\"editor.php?=".$matches[1]."\" id=\"edit\">Edit</a></li><li><a
	href=\"viewer.php?=".$matches[1]."\" id=\"view\">View</a></li></ul><div id=\"news-title\"><h3
	type=\"text\" placeholder=\"Newsletter Title\">{{save}}</h2></div><div></div></div></div>";
	

	$header = "<div id=\"main\"><div class=\"header\"><img
	src=\"https://ci4.googleusercontent.com/proxy/J5H7s6ByCuKyEi34upkJjSoIC-5-
	76F4p9JMauXj1ttM73u1X0cECHTls1GpGiqEixhRW8iQ7YsPLhEjGU8Dz5Jiyw7aDtGTHJSm5ZdPcEoybuXTQ6iUoWkF2yw6Qd8eYsRbTQKKPxHabdLU
	=s0-d-e1-ft#http://research.poly.edu/~emailmarket/admin/temp/templates/20/nyu_engineering_logo.png\" width=\"223\"
	height=\"30\" alt=\"nyu_engineering_logo.png\" title=\"nyu_engineering_logo.png\" class=\"headr-img\"></div>";

	$section = "<div class = \"section\" ng-repeat=\"section in news.sections\"><div style=\"display: inline-block;width: 100%;float: left;\"><h2
	id=\"section\">{{section.sec_title}}</h2>";

	$articles = "<div ng-repeat=\"article in section.articles\"><div class= \"article\" ><div class=\"title\"><h3
	 id=\"title\" ng-model=\"article.title\"><a target=\"_blank\"
	ng-href=\"{{article.link}}\" id=\"title-link\">{{article.title}}</a></h3></div><p id=\"publisher\"
	ng-bind-html=\"article.publisher\" >{{article.publisher}}</p><p id=\"orig_title\"
	ng-bind-html=\"article.orig_title\" >{{article.orig_title}}</p><p id=\"descr\"
	ng-bind-html=\"article.description\" >{{article.description}}</p></div><div id= \"drag\"><button id=\"drag-button\" ng-click=\"articleUp(\$index,\$parent.\$index)\">Up</button><button id=\"drag-button\" ng-click=\"articleDown(\$index,\$parent.\$index)\"> Down</button> </div></div></div><div id= \"drag-section\"><button id=\"drag-button\" ng-click=\"sectionUp(\$index)\">Up</button><button id=\"drag-button\" ng-click=\"sectionDown(\$index)\"> Down</button> </div></div>";

	$social_media = "<div class=\"section\"><h2 id=\"section\">Social
	Media</h2><div class='media' ng-repeat= 'media in news.medias'><div style=\"display: inline-block;width: 100%;float: left;\"><h3 id = 'media-source' class=\"title\"> {{media.title}}</h3><div ng-repeat=\"item in media.items\" id =
	\"items\"><div id = \"media\"><img ng-src =\"{{item.img}}\" width=\"100%\"><p
	id=\"descr\" ng-model=\"item.description\" ng-bind-html=\"item.description\"></p><span
	style=\"color:#aaaaa; line-height: 150%;\">{{item.feedback}}</span></div><div class=\"edit-media\"><div id= \"drag\"><button id=\"drag-button\" ng-click=\"itemUp(\$index,\$parent.\$index)\">Up</button><button id=\"drag-button\" ng-click=\"itemDown(\$index,\$parent.\$index)\"> Down</button> </div></div></div></div><div id= \"drag-section\"><button id=\"drag-button\" ng-click=\"mediaUp(\$index)\">Up</button><button id=\"drag-button\" ng-click=\"mediaDown(\$index)\"> Down</button> </div></div>";

	$body_end = "</div></body></html>";


	echo $head.$body_top.$notification.$menu_bar.$header.$section.$articles.$add_article.$social_media.$body_end; ?>


