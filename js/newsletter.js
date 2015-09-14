//Angular!
var newsletter = angular.module('newsApp',['ngSanitize','xeditable','ngCkeditor']);

newsletter.run(function(editableOptions) {
      editableOptions.theme = 'default';
});

newsletter.controller('newsController',function($scope,$http){
	$scope.save = "Newsletter Title"
	$scope.news =  {
		sections: [
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
	
	// $scope.update = function(){
	// 	return $http.post('/updateSection',$scope.news);
	// };
	
	$scope.sendJSON = function(){
		var json= angular.toJson($scope.news);
		$http({
			method:'POST',
			url:'send.php',
			headers:{'Content-Type':'application/x-www-form-urlencoded'},
			data:$scope.save + "&JSON:" + json,
		}).success(function(data,status,headers,config){
			console.log($scope.save + "&JSON:" + json);
			$scope.data=data;
		}).error(function(data,status,headers,config){
			$scope.status=status;
			console.log(data);
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
