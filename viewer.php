<?php

require_once '../../config.php';

$link_id = $_SERVER[REQUEST_URI];

$id = preg_match('/([0-9]+)/',$link_id, $matches);
	
$query = mysql_query(sprintf("SELECT TITLE, JSON FROM NEWSLETTER WHERE ID = '%s'",$matches[0]));

$row = mysql_fetch_row($query);

// print_r($row[1]);

$find_sections = preg_match('/({"sec_title":".*News","articles":\[.*?\n*.*\]}?]?)(?:,"medias":.*)?/',$row[1],$newsletter);

// print_r($newsletter);

$sections_replaced = str_replace('\"',"'",$newsletter[1]);

$sections = preg_split('/]},{/',$sections_replaced);

$find_medias = preg_match('/"medias":(.*)?/',$row[1],$newsletter_2);

$medias_replaced = str_replace('\"',"'",$newsletter_2[1]);
$medias_replaced = str_replace('&nbsp;'," ",$medias_replaced);

$medias = preg_split('/]},{/',$medias_replaced);
// print_r($medias);

$header ="<html ng-app=\"newsApp\"><head><title>Newsletter</title><link href=\"css/viewer.css\" rel=\"stylesheet\"><script src=\"js/jquery.min.js\"></script><script src=\"js/viewer.js\"></script><meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" /></head>";

$body_top ="<body><div id=\"menu\"><div id=\"menu-bar\"><ul id=\"editor-buttons\"><li><a href=\"/~anvu/news_brief\">Main</a></li><li><a href=# id=\"copy\"  onclick=\"show('html-div')\">Show HTML</a></li><li><a href=\"editor.php?=".$matches[1]."\" id=\"edit\">Edit</a></li></ul><div id=\"news-title\"><h3 id=\"save\" ng-model=\"save\">".$row[0]."</h3></div><div id=\"html-div\"></div></div></div>";

$nyu_header = "<div id=\"container\"><table id=\"body_holder\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%;\"><tbody><tr><td bgcolor=\"#ffffff\" align=\"center\"><table style=\"font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; padding: 0; width: 100%; max-width: 800px;\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td bgcolor=\"#57068c\" style=\"padding: 15px;\"><img src=\"http://research.poly.edu/~emailmarket/admin/temp/templates/20/nyu_engineering_logo.png\" width=\"223\" height=\"30\" alt=\"nyu_engineering_logo.png\" title=\"nyu_engineering_logo.png\" /></td></tr><tr><td bgcolor=\"#f6f6f6\" style=\"padding: 15px; border-bottom: 1px solid #eee; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;\"><p style=\"margin: 0; font-size: 20px; font-weight: normal; color: #666;\">In the News</p></td></tr><tr>";


$line = "";

foreach ($sections as $section){
	preg_match('/sec_title\":\"(.*News)\",\"articles\":\[(.*)}/',$section,$split);
	$this_section[title] = $split[1];
	if(!empty($split)){
	$line.= "<tr><td bgcolor=\"#ffffff\" style=\"font-family: 'Helvetica Neue',Helvetica, Arial, sans-serif; padding: 15px; font-size: 12px; line-height: 150%; background:#ffffff;\"><h2 style=\"font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #eeeeee; color: #7bc143; margin: 2em 0px 1em;\">".$this_section[title]."</h2>";
	$this_section[articles]=preg_split('/},{/',$split[2]);
	// unset($this_section[articles][0]);
	// print_r($split[2]);
	// print_r($this_section[articles]);
	
	
	foreach ($this_section[articles] as $article){
		// print_r($article);
		
		if (!strstr ( $article , 'img')){
			preg_match('/"title":"(.+?)",?/',$article,$title);
			$this_article[title]= $title[1];
			// print_r($article);

			preg_match('/publisher":"(.+?)"/',$article,$publisher);
			$this_article[publisher]= $publisher[1];

			preg_match('/orig_title":"(.+?)"/',$article,$orig);
			$this_article[orig_title]= $orig[1];
		
			// var_dump($this_article[orig_title]);
			// echo "\n";

			preg_match('/link":(".+?")/',$article,$art_link);
			$this_article[art_link]= $art_link[1];

			preg_match('/"description":"(.+?)","\w+?/',$article,$description);
			// print_r($description);

			if (!$description){
				preg_match('/"description":"(.+)"$/',$article,$description);		
			}
			$this_article[description] = $description[1];
			// print_r($description);

			$line .="<div><h3 style=\"margin: 1.5em 0 0.5em;\"><a href=".$this_article[art_link].">".$this_article[title]."</a></h3><p style=\"margin: 0;\"><strong>".$this_article[publisher]."</strong></p>";
			if ($this_article[orig_title] != NULL){
				$line .= "<p style=\"margin: 0;\"><i>".$this_article[orig_title]."</i></p>";
			}
			$line .= "<p style=\"margin-top:0.5em;\">".$this_article[description]."</p></div>";
		}
	};

	$line .= "</td></tr></tr>";
};
};

// print_r($medias);

if($medias[0]!=""){

$social_media = "<tr><td bgcolor=\"#ffffff\" style=\"font-family: 'Helvetica Neue',Helvetica, Arial, sans-serif; padding: 15px; font-size: 12px; line-height: 150%; background:#ffffff;\"><h2 style=\"font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#eeeeee;color:#7bc143;margin:2em 0px 1em\">Social Media</h2>";

// print_r($medias);

foreach ($medias as $media){
	// print_r($media);
	preg_match('/title\":\"(.+)\",\"items\":\[{?(.*)}?}/',$media,$split);
	$this_section[title] = $split[1];
	// print_r($split);
	$social_media.= "<div><h3 style=\"margin: 1.5em 0 0.5em;\">".$this_section[title]."</h3>";
	$this_section[items]=preg_split('/},{/',$split[2]);
	// print_r($split[2]);
	// // print_r($this_section[articles]);
	foreach ($this_section[items] as $item){
		// print_r($item);

		preg_match('/"img":"(.+)",?/',$item,$image);
		$this_item[image] = $image[1];

		// print_r($this_item[image]);

		preg_match('/"description":"(.+?)",?/',$item,$description);
		$this_item[description] = $description[1];
		// print_r($description);

		preg_match('/"feedback":"(.+?)"/',$item,$feedback);
		$this_item[feedback] = preg_replace("/(\w+), (\d+)/","$1 &bull; $2", $feedback[1]);
		// print_r($feedback);

		$social_media .="<div style=\"border: 1px solid #ddd; border-radius: 3px; padding: 5px 15px 0px; margin: 1em 0; max-width:500px\">";
		
		if(!empty($this_item[image])){
			$social_media .= "<strong></strong><img src = \"".$this_item[image]."\" tabindex=\"0\" width=\"500px\"></p>";
		};
		
		$social_media .= "<p style=\"margin:0.5em 0\"><span style=\"line-height: 150%\">".$this_item[description]."<br></span><span style=\"color:#aaaaa; line-height: 150%;\">".$this_item[feedback]."</span></p></div>";
	};

	$social_media .= "</div>";
};

$social_media .= "</td></tr>";
}

// $social_media = "<tr><td><h2 style=\"font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#eeeeee;color:#7bc143;margin:2em 0px 1em\">Social Media</h2><div style=\"border: 1px solid #ddd; border-radius: 3px; padding: 5px 15px 0px; margin: 1em 0; max-width:500px\"><p style=\"margin-bottom: 0.5em\"><img src = \"{{item.img}}\" tabindex=\"0\" width=\"500px\"><divclass=\"a65\" dir=\"ltr\" style=\"opacity: 0.01; left: 573.5px; top: 3039.171875px;\"></div></p><p style=\"margin:0.5em0\"><span style=\"line-height: 150%\">{{item.description}}<br></span></p></div></td></tr>";

$body_end ="<tr><td></td></tr><tr><td style=\"font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; padding: 15px;font-size: 12px; line-height: 150%; background: #ffffff;\"><hr style=\"margin-top: 3em; height: 0; border: 0;border-top: 1px solid #eee;\" /><p><strong>Bounce back to unsubscribe or to add a name to this email list.</strong></p><p>Robert Newell Niesen<br />Executive Assistant<br/>Office of Marketing &amp; Communications</p><p>NYU Polytechnic School of Engineering<br />15 MetroTech Center - 6th Floor<br />Brooklyn, NY 11201<br />646-997-3559 <br /><a href=\"mailto:robert.niesen@nyu.edu\">robert.niesen@nyu.edu</a> <a href=\"http://engineering.nyu.edu\"><br/>engineering.nyu.edu</a></p></td></tr><tr><td></td></tr></tbody></table></td></tr></tbody></table></div></body></html>";

// echo $header.$body_top.$section.$body_end;
// 
	echo $header.$body_top.$html.$nyu_header.$line.$social_media.$body_end;
	
	// echo $line;

?>