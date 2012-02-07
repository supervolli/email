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
	  	  $("#folders").html( folders );
		  $("li#folder").click(function(){
			  	alert($(this input).value);
			  });
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
