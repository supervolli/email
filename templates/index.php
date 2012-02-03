<?php 
#Variablen abholen

$uid = $_['uid'];
$mh = "{".$_['mailhost'].":993/imap/ssl/novalidate-cert}";
$mu = $_['mailuser'];
$mp = $_['mailpwd'];
$factive = $_['factive']; #Aktives Postfach
$hstart = $_['hstart']; #Bei welchem Header beginnen

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
<?php 
  $folder = $folders[$factive]->name;
  #echo $folder;

  #2. Verbindung nur fuer den aktiven Ordner
  $mbox2 = imap_open($folder,$mu,$mp);

  $anz = imap_num_msg($mbox2);
  #Mailbox2 nach Datum sortieren (aus dem PHP-Manual gemoppst)
#  $original_order = $mbox2;
#  $sorted_mbox2 = imap_sort($mbox2, "SORTDATE", 0); 
#  $totalrows = imap_num_msg($mbox2); 
#  $startvalue = 0; 
#  while ($startvalue < $totalrows) { 
#    $header = imap_header($mbox2, $sorted_mbox2[$startvalue]); 
#    $mid_1 = $header->message_id; 
#    $i = 0; 
#    while ($i < ($totalrows + 1)) { 
#      $header1 = imap_header($original_order, $i); 
#      $mid_2 = $header1->message_id; 
#      if ($mid_1 == $mid_2) { 
#        $id = $i; 
#     } 
#      $i ++; 
#    }
#    $startvalue++; 
#  } 

  #Headers $hstart + 25
  for ($i=$anz; $i> ($anz-25); $i--){
    $header = imap_headerinfo($mbox2,$i);
    if ($header){
      $subj = $header->subject;
      $date  = $header->Date;
      echo $date." - ".$subj."<br />";
    }
  }

  imap_close($mbox2);
?>
</div>



<?php 
  if ($mbox){	
    imap_close($mbox); 
  }
?>
