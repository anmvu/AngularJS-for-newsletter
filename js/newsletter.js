//Angular!
var newsletter = angular.module('newsApp',['ngSanitize','xeditable','ngCkeditor']);

newsletter.run(function(editableOptions) {
      editableOptions.theme = 'default';
});

newsletter.controller('newsController',function($scope,$http){
	var date = new Date();
	$scope.news =  {
		save: date.toLocaleDateString(),
		sections: [
			{
				title: "Faculty",
				articles: [
					{
						title: "In Memoriam: Eli Pearce",
						link:'http://engineering.nyu.edu/news/2015/05/29/memoriam-eli-pearce',
						publisher: "NYU Newsroom",
						orig_title:"   ",
						description: "When <strong>Professor Eli Pearce</strong> passed away on May 19, 2015, a slice of Poly history passed along with him. Pearce had been affiliated with the school, then known as the Polytechnic Institute of Brooklyn, since the mid-1950s, when he conducted his doctoral studies in chemistry here. As a student, he learned with such luminaries as Herman Frances Mark, who is often called the Father of Polymer Science, and Charles Overberger, another influential chemist who helped establish the study of polymers as a major sub-discipline."
					}
				]
			}
		]
	};

	$scope.editorOptions={
		language:'en',
		uiColor: '#000000',
	};

	// $scope.ckeditordata = CKEDITOR.instances.tbDetails.getData();

	//Add Section
	$scope.addSection = function(){
		$scope.news.sections.temp={
			title: "Section Title",
			articles:[
			// 	{
			// 		title:"Article Title",
			// 		link:"Link",
			// 		publisher: "Publisher",
			// 		orig_title: "Original Title",
			// 		description: "Description"
			// 	}
			]
		};
		$scope.news.sections.push(this.news.sections.temp);
	};

	//Delete Section
	$scope.deleteSection = function(index){
		$scope.news.sections.splice(index,1);
	};
	
	//addArticle
	$scope.addArticle = function(index){
		$scope.news.sections[index].articles.push($scope.news.sections[index].articles.temp);
		$scope.news.sections[index].articles.temp={};
	};

	//deleteArticle
	$scope.deleteArticle = function(index,index2){
		$scope.news.sections[index].articles.splice(index2,1);
	};
	
	$scope.update = function(){
		return $http.post('/updateSection',$scope.news);
	};
	
	$scope.sendJSON = function(){
		var stuff = angular.toJson($scope.news);
		var json= JSON.stringify(stuff);
		console.log(json);
		$http({
			method:'POST',
			url:'send.php',
			headers:{'Content-Type':'application/x-www-form-urlencoded'},
			data: json,
		}).success(function(data,status,headers,config){
			console.log("success");
			$scope.data=data;
		}).error(function(data,status,headers,config){
			$scope.status=status;
		});
	};	
	
});


// Menu bar

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
};
