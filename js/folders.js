function testJQuery(){
	if(typeof jQuery == "function")
		  alert("jQuery geladen");
		else
		  alert("jQuery nicht geladen");
}

function loadHeaders( folder, offset ){
	$.ajax({
		  url: "ajax/headers.php?folder=" + folder + "&offset=" + offset,
		  cache: false,
		  success: function( headers ){
		    $("#headers").append( headers );
		  },
		  error: function ( error ) {
			alert( error )
		  } 
		});
}