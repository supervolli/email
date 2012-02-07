function testJQuery(){
	if(typeof jQuery == "function")
		  alert("jQuery geladen");
		else
		  alert("jQuery nicht geladen");
}

function loadHeaders( folder, offset ){
	$.ajax({
		  url: "ajax/headers.php?folder=" + folder + '&offset=' + offset,
		  cache: false,
		  success: function( headers ){
			  if (offset == 0 ) {
				  $("#headers").html( headers );
			  } else {
				  $("#headers").append( headers );
			  }
			  //Klick auf "Weitere Mails laden"
			  $("li#mehrmails").click(function(){
				  offset = offset + 30;
				  loadHeaders( folder, offset );
				  $(this).hide("slow");
			  });
			  //Klick auf die Email
			  $("li#mailheader").click(function(){
				 alert ( $(this).find("#mailfolder").val() ); 
			  });
		  },
		  error: function ( error ) {
			  alert( error )
		  } 
		});
}

