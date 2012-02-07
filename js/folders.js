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
			  //Neues Postfach oder Zusätzliche Mails?
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
				 folder = $(this).find("#mailfolder").val() ;
				 msgno  = $(this).find("#mailnummer").val() ;
				 loadEmail( folder, msgno );
			  });
		  },
		  error: function ( error ) {
			  alert( error )
		  } 
		});
}

function loadEmail( folder, msgno ){
	$.ajax({
		  url: "ajax/email_lesen.php?folder=" + folder + "&msgno=" + msgno,
		  cache: false,
		  success: function( email ){
			  $("#maildiv").html( email );
		  }
	});
}
