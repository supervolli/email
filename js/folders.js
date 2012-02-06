function testJQuery(){
	if(typeof jQuery == "function")
		  alert("jQuery geladen");
		else
		  alert("jQuery nicht geladen");
}

function loadHeaders( folder ){
	$.ajax({
		  url: "ajax/headers.php?folder=" + folder + '&offset=0',
		  cache: false,
		  success: function( headers ){
			  $("#headers").html( headers );
		  },
		  error: function ( error ) {
			  alert( error )
		  } 
		});
}