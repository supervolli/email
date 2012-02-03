<?php 
#Variablen abholen

$uid = $_['uid'];
$mh = "{".$_['mailhost'].":993/imap/ssl/novalidate-cert}";
$mu = $_['mailuser'];
$mp = $_['mailpwd'];
$factive = $_['factive']; #Aktives Postfach

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
  $mgesamt=imap_num_msg($mbox);

  # Sortieren... der Ordner
  sort($folders);

  if ($folders == false) {
      echo "Abruf fehlgeschlagen";
  } else {
      echo "<ul id=\"folders\">";
      #echo "<li>".$mgesamt." Emails</li>";

      foreach ($folders as $key=>$val) {
          # Postfachnamen bearbeiten
          $fname=str_replace($mh,'',imap_utf7_decode($val->name));
          $fname = ($fname=='INBOX') ? 'Posteingang'.$neu : $fname;
          $fname=str_replace('INBOX.','', $fname );
          
          # Postfachstatus
          $fstatus=imap_status($mbox, $val->name, SA_ALL);
          echo imap_last_error();
          $funseen=($fstatus->unseen <> '0') ? " (<b>".$fstatus->unseen."</b>)" : '' ;

          # Postfach aktiv?
          $fclass =  ($factive == $key) ? ' class="active"' : '';

	  # Postfach anzeigen
          echo "<li".$fclass."><a href=\"index.php?factive=".$key."\">".$fname.$funseen."</a></li>";
  
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
