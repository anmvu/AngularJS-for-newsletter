$(window).load(function(){
	var html = $('#body_holder').html();
	// console.log(html);
	$('#html-div').text(html);	
});


// Menu bar

//Select All

function show(element){
	var node = document.getElementById(element);
	var button = document.getElementById('copy');
	if(button.innerHTML == "Show HTML"){
		node.style.display='block';
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
		button.innerHTML = "Hide HTML";
	}
	else{
		node.style.display="none";
		button.innerHTML = "Show HTML";
	}
};

function hide(element){
	var node = document.getElementById(element);
	node.style.display='';
};

