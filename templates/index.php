<?php 
$uid = $_['uid'];
$mh = "{".$_['mailhost'].":993/imap/ssl/novalidate-cert}";
$mu = $_['mailuser'];
$mp = $_['mailpwd'];
#Mailbox oefnen
$mbox = imap_open($mh."INBOX", $mu, $mp);
echo imap_last_error();
?>
<div id="controls">
<!--<b>Konfiguration</b><br />-->
<input type="button" id="email_new" value="Neue Email" original-title></input>
<input type="button" id="email_config" value="Konfigurieren" original-title></input>
</div>

<div id="leftcontent" class="leftcontent">

<?php
if ($mbox) {
  #Postfaecher abholen
  $folders=imap_getmailboxes($mbox,$mh,"*");
  #Anzahl der Emails gesamt
  $gesamt=imap_num_msg($mbox);
  sort($folders);

  if ($folders == false) {
      echo "Abruf fehlgeschlagen";
  } else {
      echo "<ul id=\"contacts\"><li><b>Postf&auml;cher</b> (".$gesamt." Emails)</li>";
      foreach ($folders as $key=>$val) {
          # Postfachnamen bearbeiten
          $fname=str_replace($mh,'',imap_utf7_decode($val->name));
          $fname = ($fname=='INBOX') ? 'Posteingang' : $fname;
          $fname=str_replace('INBOX.','', $fname );
          echo "<li>".$fname."</li>";
  
      }
      echo "</ul>";
  }
}
?>

</div>

<div id="rightcontent" class="rightcontent">

	<b>Kopfzeilen</b> sieht man dann hier
<?php 
	$anz=$message_count = imap_num_msg($mbox);
	#$sort_mbox=imap_sort($mbox, "SORTDATE", 0);
	for ($i=0;$i<30;$i++){
		$header = imap_headerinfo(mbox, $i);
		echo $header->date;
		echo $header->fromaddress;
		echo $header->subject;
		echo "<br />";
	}
	
?>
</div>
<?php 
if ($mbox){	
	imap_close($mbox); 
}
?>
