//Angular!
newsletter.run(function(editableOptions) {
      editableOptions.theme = 'default';
      });

newsletter.controller('newsController',function($scope){
	
	$scope.sections =  {
		section: "Faculty",
		articles: [
			{
				title: "In Memoriam: Eli Pearce",
				link:'http://engineering.nyu.edu/news/2015/05/29/memoriam-eli-pearce',
				publisher: "NYU Newsroom",
				orig_title:"   ",
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
var newSection = '<div class = "section" ng-controller="newsController"><h2 id="section" editable-text="sections.section">{{sections.section}}</h2><div class = "article" ng-repeat="article in sections.articles"><h3 id="title" editable-text="article.title"><a editable-text="article.link" href="{{article.link}}">{{article.title}}</a></h3><p id="publisher" editable-text="article.publisher">{{article.publisher}}</p><p id="orig_title" editable-text="article.orig_title">{{article.orig_title}}</p><p id="descr" ng-bind-html="article.description" editable-text="article.description"></p></div><div ng-mouseenter="showEditor=true" ng-mouseleave="showEditor=false" class="article editor"><div ng-show="showEditor"><div><h3>Add article</h3><div><form role="form" ng-submit="addArticle()"><div><label for="articleName">Article Name</label><div><input type="text" ng-model="sections.articles.temp.title" placeholder="Faculty News"></div></div><div><label for="articleLink"> Article Link</label><div><input type="text"ng-model="sections.articles.temp.link" placeholder="htt://engineering.nyu.edu"></div></div><div><label for="articlePub"> Publisher </label><div><input type="text"ng-model="sections.articles.temp.publisher" placeholder="NYU"></div></div><div><label for="articleOrgTitle"> Original Title</label><div><input type="text"ng-model="sections.articles.temp.orig_title" placeholder="Top 5"></div></div><div><label for="articleDescr"> Description</label><div><input type="text"ng-model="sections.articles.temp.description" placeholder="We are number 1!"></div></div><div><div><button type="submit">Add</button></div></div></form></div></div></div></div></div>'
$("#add-section").click(function(){
	var $section = $('#main').append(newSection);
});


//Select All

function selectText(element){
	var node = document.getElementById(element);
	if ( document.selection ) {
       var range = document.body.createTextRange();
       range.moveToElementText( node  );
       range.select();
   } 
   	else if ( window.getSelection ) {
       var range = document.createRange();
       range.selectNodeContents( node );
       window.getSelection().removeAllRanges();
       window.getSelection().addRange( range );
   	}

}

// //Send to Server
// 	$("#main").ready(function() { 
// 	    $.getJSON( $("#json").html() , function(json) {
// 	        $.each(json.data, function(index, value) { $('.data').append(value.a+'<br />'); } );
// 	    });
// 	});
// ;