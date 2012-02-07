<div id="controls">
	<input type="button" id="email_new" value="Neue Email"></input>
</div>
<div id="folderdiv">
  <ul id="folders">
    <li class="folder_head">Postf&auml;cher --- reload</li>
  </ul>
</div>

<script type="text/javascript">
<!--
/* Erstes Laden der Ordner */
$.ajax({
	  url: "ajax/folders.php",
	  cache: false,
	  dataType: "text",
	  success: function( folders ){
		  // Ordner ausgeben
	  	  $("#folders").html( folders );
	  	  // Was passiert bei Klick auf Ordner
		  $("li#folder").click(function(){
			  //alle erstmal aufhellen
			  $("#folder").addClass("folder");
			  // Den einen dunkel werden lassen
              $(this).addClass("folder_sel");
              //Postfach lasden
			  loadHeaders($(this).find("input").val(), 0);
		  });
		  $("li#folder").hover(function(){
			  $(this).addClass("folder_hover");
		  });
		  //Ersten Ordner laden
		  $("#folder:first").addClass("folder_sel");
		  loadHeaders($("#folder:first").find("input").val(), 0);
	  },
	  error: function ( error ) {
		alert( error )
	  } 
	});
//-->
</script>

<div id="headersdiv">
	<ul id="headers">&nbsp;
	</ul>
</div>
