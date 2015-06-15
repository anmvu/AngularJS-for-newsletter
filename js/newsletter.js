//Angular!
newsletter.controller('newsController',function($scope){
	
	$scope.sections =  {
		section: "Faculty",
		articles: [
			{
				title: "In Memoriam: Eli Pearce",
				link:'http://engineering.nyu.edu/news/2015/05/29/memoriam-eli-pearce',
				publisher: "NYU Newsroom",
				orig_title:"",
				description: "When <strong>Professor Eli Pearce</strong> passed away on May 19, 2015, a slice of Poly history passed along with him. Pearce had been affiliated with the school, then known as the Polytechnic Institute of Brooklyn, since the mid-1950s, when he conducted his doctoral studies in chemistry here. As a student, he learned with such luminaries as Herman Frances Mark, who is often called the Father of Polymer Science, and Charles Overberger, another influential chemist who helped establish the study of polymers as a major sub-discipline."
			}
		]
	};
	$scope.addItem = function(){
		$scope.sections.articles.push(this.sections.articles.temp);
		$scope.sections.articles.temp={};
	};
	
});



// Menu bar

//Add Section
$(function(){
	var newSection="<div class = \"section\" ng-controller=\"newsController\"><h2 id=\"section\">{{sections.section}}</h2><div class = \"article\" ng-repeat=\"article in sections.articles\"><h3 id=\"title\"><a href=\"{{article.link}}\">{{article.title}}</a></h3><p id=\"publisher\">{{article.publisher}}</p><p id=\"descr\" ng-bind-html=\"article.description\"></p></div><div class=\"editContainer\" ng-mouseenter=\"showEditor=true\" ng-mouseleave=\"showEditor=false\"><div ng-show=\"showEditor\" ng-include src=\"'editor.html'\"></div></div></div>";
	$("#add-section").click(function(){
		var $section = $('#main').append(newSection);
	});
});

//Select All
function selectText( containerid ) {

   var node = document.getElementById( containerid );

   if ( document.selection ) {
       var range = document.body.createTextRange();
       range.moveToElementText( node  );
       range.select();
   } else if ( window.getSelection ) {
       var range = document.createRange();
       range.selectNodeContents( node );
       window.getSelection().removeAllRanges();
       window.getSelection().addRange( range );
   }
}

//Send to Server
$(function(){
	$("#main").ready(function() { 
	    $.getJSON( $("#json").html() , function(json) {
	        $.each(json.data, function(index, value) { $('.data').append(value.a+'<br />'); } );
	    });
	});
});