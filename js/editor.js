//Angular!
var newsletter = angular.module('newsApp',['ngSanitize','xeditable','ngCkeditor','dndLists']);

newsletter.run(function(editableOptions) {
      editableOptions.theme = 'default';
});

newsletter.controller('newsController',function($scope,$http,$location,$document){
	
	$scope.save = "Newsletter Title";
	$scope.news =  {
	};

	$id = /([0-9]+)/.exec($location.absUrl());
	// console.log($location.absUrl());

	if (/([0-9]+)/.exec($location.absUrl()) != null){
		$http.get("retrieve.php?=" + $id[0])
		.success(function(data){
			$scope.save = data[0];
			// console.log(data[1]);
			$scope.news = angular.fromJson(data[1]);
			console.log(data);
			$scope.autosave = $id[0] + "&title:" + data[0] + "&JSON:" + data[1];
		});
	}

	if ($id == null){
		$id = [];
		$id.push("none");
	}

	$scope.editorOptions={
		language:'en',
		uiColor: '#000000',
	};
	
	$scope.notesEditorOptions={
		language:'en',
		uiColor:'#000000',
		height: '100px',
	}

	// $scope.ckeditordata = CKEDITOR.instances.tbDetails.getData();
	
	// console.log($scope.news.medias);

	//Add Section
	$scope.addSection = function(){
		if(!Array.isArray($scope.news.sections)){
			$scope.news.sections = [];
		}
		$scope.news.sections.temp={
			sec_title: "Section Title",
			articles:[
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

	$scope.deleteMedia = function(){
		$scope.news.medias.splice(0,$scope.news.medias.length);
		showMedia="false";
	}

	$scope.addMediaSection = function(){
		if (Array.isArray($scope.news.medias)){
			$scope.news.medias = [];
		};
	}

	//addMediaSource
	$scope.addMediaSource = function(){
		if(!Array.isArray($scope.news.medias)){
			$scope.news.medias = [];
		}
		$scope.news.medias.temp={
			title: "Media Source e.g. Facebook",
			items:[]
		};
		$scope.news.medias.push(this.news.medias.temp);
	};

	//deleteMediaSource
	$scope.deleteMediaSource = function(index){
		$scope.news.medias.splice(index,1);
	};

	//addArticle
	$scope.addMediaItem = function(index){
		$scope.news.medias[index].items.push($scope.news.medias[index].items.temp);
		$scope.news.medias[index].items.temp={};
	};

	//deleteArticle
	$scope.deleteMediaItem = function(index,index2){
		$scope.news.medias[index].items.splice(index2,1);
	};
	
	$scope.sendJSON = function(){
// 		$scope.prev = $scope.autosave;
// 		console.log('called');
		$scope.newsave = $id[0] + "&title:" + $scope.save + "&JSON:" + angular.toJson($scope.news);
		if ($scope.newsave != $scope.autosave && $scope.newsave != $scope.prev){
			$http({
				method:'POST',
				url:'send.php',
				headers:{'Content-Type':'application/x-www-form-urlencoded'},
				data:$scope.newsave,
			}).success(function(data,status,headers,config){
				$scope.data = data;
				$scope.prev = $scope.autosave;
				$scope.autosave = $scope.newsave;
// 				console.log(data);
				// alert('Saved');
				$("#saved").fadeIn("slow");
				$("#all").click(function(){
					$("#saved").fadeOut("slow");
				})
			}).error(function(data,status,headers,config){
				$scope.status=status;
// 				console.log(data);
				$("#failed").fadeIn("slow");
				$("#all").click(function(){
					$("#failed").fadeOut("slow");
				})
			});
		}
	};
	
	$scope.ping = function(){
		var date = new Date();
		var now = "Edited on: " + date.toDateString() + " @ " + date.toTimeString()
		$http({
				method:'POST',
				url:'index.php',
				headers:{'Content-Type':'application/x-www-form-urlencoded'},
				data:$id[0]+"&" + now,
			}).success(function(data,status,headers,config){
// 				console.log('success');
				$scope.data = data;
			}).error(function(data,status,headers,config){
				$scope.status=status;
			});
			
	};

	angular.element(document).ready(function(){
		// setInterval($scope.sendJSON, 10000);
		// setInterval($scope.ping, 5000);
	})
	
	$scope.dragoverCallback = function(event, index, external, type) {
		$scope.logListEvent('dragged over', event, index, external, type);
		return index > 0;
    };

    $scope.dropCallback = function(event, index, item, external, type, allowedType) {
		$scope.logListEvent('dropped at', event, index, external, type);
		if (external) {
		    if (allowedType === 'itemType' && !item.label) return false;
		    if (allowedType === 'containerType' && !angular.isArray(item)) return false;
		}
		return item;
    };

    $scope.logEvent = function(message, event) {
		console.log(message, '(triggered by the following', event.type, 'event)');
		console.log(event);
    };

    $scope.logListEvent = function(action, event, index, external, type) {
		var message = external ? 'External ' : '';
		message += type + ' element is ' + action + ' position ' + index;
		$scope.logEvent(message, event);
    };
	$scope.$watch('model', function(model) {
		$scope.modelAsJson = angular.toJson(model, true);
	}, true);
	
	$scope.sectionUp = function(index){
		if(index != 0){
			if (index-1 >= $scope.news.sections.length){
				var i = index-1 - $scope.news.sections.length;
				while ((i--) + 1){
					$scope.news.sections.push(undefined);
				}
			}
			$scope.news.sections.splice(index-1,0,$scope.news.sections.splice(index,1)[0]);
		}
	};
	
	$scope.sectionDown = function(index){
		if(index != $scope.news.sections.length-1){
			if (index+1 >= $scope.news.sections.length){
				var i = index+1 - $scope.news.sections.length;
				while ((i--) + 1){
					$scope.news.sections.push(undefined);
				}
			}
			$scope.news.sections.splice(index+1,0,$scope.news.sections.splice(index,1)[0]);
		}
	};
	
	$scope.articleUp = function(index,index2){
		if(index != 0){
			if (index-1 >= $scope.news.sections[index2].articles.length){
				var i = index-1 - $scope.news.sections[index2].articles.length;
				while ((i--) + 1){
					$scope.news.sections[index2].articles.push(undefined);
				}
			}
			$scope.news.sections[index2].articles.splice(index-1,0,$scope.news.sections[index2].articles.splice(index,1)[0]);
		}
		else{
			if (index2 != 0){
				$scope.news.sections[index2-1].articles.push($scope.news.sections[index2].articles.splice(index,1)[0]);
			}
		}
	};
	
	$scope.articleDown = function(index,index2){
		if(index != $scope.news.sections[index2].articles.length-1){
			if (index+1 >= $scope.news.sections[index2].articles.length){
				var i = index+1 - $scope.news.sections[index2].articles.length;
				while ((i--) + 1){
					$scope.news.sections[index2].articles.push(undefined);
				}
			}
			$scope.news.sections[index2].articles.splice(index+1,0,$scope.news.sections[index2].articles.splice(index,1)[0]);
		}
		else{
			if (index2 != $scope.news.sections.length-1){
				$scope.news.sections[index2+1].articles.splice(0,0,$scope.news.sections[index2].articles.splice(index,1)[0]);
			}
		}
	};
	
	$scope.mediaUp = function(index){
		if(index != 0){
			if (index-1 >= $scope.news.sections.length){
				var i = index-1 - $scope.news.medias.length;
				while ((i--) + 1){
					$scope.news.medias.push(undefined);
				}
			}
			$scope.news.medias.splice(index-1,0,$scope.news.medias.splice(index,1)[0]);
		}
	};
	
	$scope.mediaDown = function(index){
		if(index != $scope.news.medias.length-1){
			if (index+1 >= $scope.news.medias.length){
				var i = index+1 - $scope.news.medias.length;
				while ((i--) + 1){
					$scope.news.sections.push(undefined);
				}
			}
			$scope.news.medias.splice(index+1,0,$scope.news.medias.splice(index,1)[0]);
		}
	};
	
	$scope.itemUp = function(index,index2){
		if(index != 0){
			if (index-1 >= $scope.news.medias[index2].items.length){
				var i = index-1 - $scope.news.medias[index2].items.length;
				while ((i--) + 1){
					$scope.news.medias[index2].items.push(undefined);
				}
			}
			$scope.news.medias[index2].items.splice(index-1,0,$scope.news.medias[index2].items.splice(index,1)[0]);
		}
		else{
			if (index2 != 0){
				$scope.news.medias[index2-1].items.push($scope.news.medias[index2].items.splice(index,1)[0]);
			}
		}
	};
	
	$scope.itemDown = function(index,index2){
		if(index != $scope.news.medias[index2].items.length-1){
			if (index+1 >= $scope.news.medias[index2].items.length){
				var i = index+1 - $scope.news.medias[index2].items.length;
				while ((i--) + 1){
					$scope.news.medias[index2].items.push(undefined);
				}
			}
			$scope.news.medias[index2].items.splice(index+1,0,$scope.news.medias[index2].items.splice(index,1)[0]);
		}
		else{
			if (index2 != $scope.news.medias.length-1){
				$scope.news.medias[index2+1].items.splice(0,0,$scope.news.medias[index2].items.splice(index,1)[0]);
			}
		}
	};
	
});



// function deleteMediaSection(){
// 	document.getElementById('media-section').remove();
// }