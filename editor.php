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

	$notification = "<div class = \"note\" id=\"saved\">Saved!<span class=\"dismiss\"><a title=\"dismiss\" id=\"close\"> x </a></span></div><div class = \"note \"id=\"failed\">Failed to AutoSave. Save then Refresh.<span class=\"dismiss\"><a title=\"dismiss\" id=\"close\"> x </a></span></div>";

		$menu_bar = "<div id=\"menu\"><div id=\"menu-bar\"><ul id=\"editor-buttons\"><li><a href=\"/~anvu/news_brief\">Main</a></li><li
	id=\"add-section\"><a href=# id=\"add-section\" ng-click=\"addSection()\">Add Section</a></li><li><a href=#
	ng-click=\"showMedia=true; addMediaSection();\" id=\"add-media\">Add Social Media</a></li>";

	if (!$id){ $menu_bar .= "<li><a href=# id=\"export\" ng-click=\"sendJSON()\">Save</a></li></ul>";
	}
	else{ $menu_bar .= "<li><a href=# id=\"export\" ng-click=\"sendJSON()\">Save</a></li><li><a href=\"reorder.php?=".$matches[1]."\" id=\"reorder\">Reorder</a></li><li><a
	href=\"viewer.php?=".$matches[1]."\" id=\"view\">View</a></li></ul>";
	}
	
	$menu_bar .= "<div id=\"news-title\"><h3
	type=\"text\"editable-text=\"save\" placeholder=\"Newsletter Title\">{{save}}</h2></div></div></div>";

	$header = "<div id=\"main\"><div class=\"header\"><img
	src=\"https://ci4.googleusercontent.com/proxy/J5H7s6ByCuKyEi34upkJjSoIC-5-
	76F4p9JMauXj1ttM73u1X0cECHTls1GpGiqEixhRW8iQ7YsPLhEjGU8Dz5Jiyw7aDtGTHJSm5ZdPcEoybuXTQ6iUoWkF2yw6Qd8eYsRbTQKKPxHabdLU
	=s0-d-e1-ft#http://research.poly.edu/~emailmarket/admin/temp/templates/20/nyu_engineering_logo.png\" width=\"223\"
	height=\"30\" alt=\"nyu_engineering_logo.png\" title=\"nyu_engineering_logo.png\" class=\"headr-img\"></div>";

	$section = "<div class = \"section\" ng-repeat=\"section in news.sections\"><h2  editable-text=\"section.sec_title\"
	id=\"section\">{{section.sec_title}}</h2><div ng-mouseenter=\"showUrl=true\" ng-mouseleave=\"showUrl=false\"
	id=\"delete-section\"><div id=\"delete\"><button type=\"submit\"
	ng-click=\"deleteSection(\$index)\"> Delete </button></div></div>";

	$articles = "<div class = \"article\" ng-repeat=\"article in section.articles\"><div class=\"title\"><h3
	editable-text=\"article.title\" id=\"title\" ng-model=\"article.title\"><a target=\"_blank\" ng-href=\"{{article.link}}\"
	id=\"title-link\">{{article.title}}</a></h3><div ng-mouseenter=\"showButtons=true\"
	ng-mouseleave=\"showButtons=false\" class=\"edit-url\"><div id=\"edit-url\"><span
	editable-text=\"article.link\" e-form=\"textBtnForm\" ></span><button ng-click=\"textBtnForm.\$show()\">Edit Url
	</button><button type=\"submit\" ng-click=\"deleteArticle(\$parent.\$index,\$index)\"> Delete
	</button></div></div></div><p id=\"publisher\" ng-model=\"article.publisher\" editable-text=\"article.publisher\"><strong>{{article.publisher}}</strong></p><p
	id=\"orig_title\" ng-model=\"article.orig_title\" editable-text=\"article.orig_title\"><i>{{article.orig_title}}</i></p><p
	id=\"descr\" ng-model=\"article.description\" ckeditor=\"editorOptions\">{{article.description}}</p></div>";

	$add_article = "<div id=\"editor\"><div
	id=\"visibleEditor\" ><div id=\"box\"><h2 id=\"editor-header\">Add article </h2><div><form
	role=\"form\" ng-submit=\"addArticle(\$index)\"><div class=\"form\"><label for=\"articleName\"
	class=\"label\"><h3>Article Name </h3></label><div class=\"input\"><input type=\"text\"
	ng-model=\"section.articles.temp.title\" placeholder=\"Article Name\"></div></div><div class=\"form\"><label
	for=\"articleLink\" class=\"label\"><h3> Article Link </h3></label><div class=\"input\"><input
	type=\"url\"ng-model=\"section.articles.temp.link\" placeholder=\"http://engineering.nyu.edu\"></div></div><div
	class=\"form\"><label for=\"articlePub\" class=\"label\" id=\"descr-label\"><h3> Publisher </h3> </label><div class=\"input\" style=\"height:120px\" ><textarea style=\"height=50px\" ckeditor=\"newsEditorOptions\" ng-model=\"section.articles.temp.publisher\"
	id=\"add-notes\"></textarea></div></div><div
	class=\"form\"><label for=\"articleOrgTitle\" id=\"descr-label\" class=\"label\"><h3> Notes </h3></label><div class=\"input\" style=\"height:120px\"><textarea style=\"height=50px\" ckeditor=\"newsEditorOptions\" ng-model=\"section.articles.temp.orig_title\"
	id=\"add-notes\"></textarea></div></div><div class=\"form\"><label for=\"articleDescr\" class=\"label\" id=\"descr-label\"><h3> Description
	</h3></label><div class=\"input descr\"><textarea ckeditor=\"editorOptions\" ng-model=\"section.articles.temp.description\"
	id=\"add-editor\"></textarea></div></div><div><div><button type=\"submit\"
	id=\"add\">Add</button></div></div></form></div></div></div></div></div>";

	$social_media = "<div class=\"section\" ng-show=\"news.medias.length || showMedia\"><h2 id=\"section\">Social Media</h2><div ng-mouseenter=\"showMediaButtons=true\" ng-mouseleave=\"showMediaButtons=false\" id=\"delete-media\"><div id=\"delete\"><button type=\"submit\" ng-click=\"addMediaSource()\">Add Media Source</button><button type=\"submit\" ng-click=\"deleteMedia(); showMedia=false;\"> Delete </button></div></div><div class='media' ng-repeat= 'media in news.medias'><h3 id = 'media-source' editable-text=\"media.title\" class=\"title\"> {{media.title}}</h3><div ng-mouseenter=\"showUrl=true\" ng-mouseleave=\"showUrl=false\" id=\"delete-media\"><div id=\"delete\"><button type=\"submit\" ng-click=\"deleteMediaSource(\$index)\"> Delete </button></div></div><div ng-repeat=\"item in media.items\" id = \"items\"><div id = \"media\"><img ng-src =\"{{item.img}}\" width=\"100%\" editable-text=\"item.img\"><p id=\"descr\" ng-model=\"item.description\"
		ckeditor=\"editorOptions\">{{item.description}}</p><span style=\"color:#aaaaa; line-height: 150%;\">{{item.feedback}}</span></div><div ng-mouseenter=\"showButtons=true\"
		ng-mouseleave=\"showButtons=false\" class=\"edit-media\"><div id=\"edit-url\"><button type=\"submit\"
		ng-click=\"deleteMediaItem(\$parent.\$index,\$index)\"> Delete </button></div></div></div><div
		ng-mouseenter=\"showMediaEditor=true\" ng-mouseleave=\"showMediaEditor=false\" id=\"editor\"><div id=\"visibleEditor\"
		><div id=\"box\"><h2 id=\"editor-header\">Add Media Item</h2><div><form role=\"form\"
		ng-submit=\"addMediaItem(\$index)\"><div class=\"form\"><label for=\"articleName\" class=\"label\"><h3>Item Image
		</h3></label><div class=\"input\"><input type=\"url\" ng-model=\"media.items.temp.img\"
		placeholder=\"image-source\"></div></div><div class=\"form\"><label for=\"articleDescr\" class=\"label\"
		id=\"descr-label\"><h3> Description </h3></label><div class=\"input descr\"><textarea ckeditor=\"editorOptions\"
		ng-model=\"media.items.temp.description\" id=\"add-editor\"></textarea></div></div><div class=\"form\"><label for=\"articleDescr\" class=\"label\"
		id=\"descr-label\"><h3> Comments, Likes, Shares </h3></label><div class=\"input descr\"><input type=\"text\" ng-model=\"media.items.temp.feedback\"
		placeholder=\"4 comments,5 likes,6 shares (seperate by commas)\"></div></div><div><div><button
		type=\"submit\" id=\"add\">Add</button></div></div></form></div></div></div></div></div></div>";

	$body_end = "</div></body></html>";


	echo $head.$body_top.$notification.$menu_bar.$header.$section.$articles.$add_article.$social_media.$body_end; ?>


