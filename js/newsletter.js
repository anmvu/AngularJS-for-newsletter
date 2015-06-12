//Angular!
newsletter.controller('newsController',function($scope){
	
	$scope.sections =  {
		section: "Faculty",
		articles: [
			{
				title: "<a target='_blank' href='http://engineering.nyu.edu/news/2015/05/29/memoriam-eli-pearce'>In Memoriam: Eli Pearce</a>",
				publisher: "NYU Newsroom",
				description: "When <strong>Professor Eli Pearce</strong> passed away on May 19, 2015, a slice of Poly history passed along with him. Pearce had been affiliated with the school, then known as the Polytechnic Institute of Brooklyn, since the mid-1950s, when he conducted his doctoral studies in chemistry here. As a student, he learned with such luminaries as Herman Frances Mark, who is often called the Father of Polymer Science, and Charles Overberger, another influential chemist who helped establish the study of polymers as a major sub-discipline."
			}
		]
	
};
	
	// $scope.addItem = function(){
	// 	$scope.sections.articles.push(this.sections.temp);
	// 	$scope.sections.temp={};
	// }
});



// Menu bar

//Add Section

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
