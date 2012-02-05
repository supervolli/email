<?php 

#Variablen abholen
$uid = $_['uid'];
$mh = "{".$_['mailhost'].":993/imap/ssl/novalidate-cert}";
$mu = $_['mailuser'];
$mp = $_['mailpwd'];
$factive = $_['factive']; #Aktives Postfach
$hstart = $_['hstart']; #Bei welchem Header beginnen
$msg = $_['msg']; # Zu ladene Email

$display = ($msg == 'nomail') ? 'none' : 'block';

#Mailbox oeffnen
$mbox = imap_open($mh."INBOX", $mu, $mp);
echo imap_last_error();
?>

<div id="controls">
<input type="button" id="email_new" value="Neue Email")"></input>
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

echo '</div> 
      <div id="rightcontent" class="rightcontent">';
 
  $folder = $folders[$factive]->name;
  #echo $folder;

  #2. Verbindung nur fuer den aktiven Ordner
  $mbox2 = imap_open($folder,$mu,$mp);

  $anz = imap_num_msg($mbox2);

  echo '<table class="headers">';
  echo '<thead>
         <tr>
           <th style="width: 100px;">Datum</th>
           <th>Betreff</th>
           <th style="width: 120px;">Von</th>
         </tr>
       </thead>
       <tbody>';
  # vorherige Mails
  if ($hstart > 49) {
    $von = ($hstart > 50)? ($hstart - 50) : 1;
    $bis = $hstart -1;
    echo '<tr>
            <th colspan="3" class="hstart">
              <a href="index.php?factive='.$factive.'&hstart='.($von - 1).'">Email '.$von.' bis '.$bis.'</a>
          </th>
         </tr>';
  }  

  #Headers $hstart + 25
  for ($i=$hstart; $i < ($hstart + 50); $i++){
    $header = imap_headerinfo($mbox2,($anz - $i), 20, 100); 
    if ($header){
      $subj = imap_utf8($header->subject);
      $date = date("d. M Y H:m",$header->udate);
      $from = imap_utf8($header->fetchfrom);
      $msgno = trim($header->Msgno);
      $unseen = $header->Unseen;

      # Email Link zum oeffnen
      $subj = '<a href="index.php?factive='.$factive.'&hstart='.$hstart.'&msg='.$msgno.'">'.$subj.'</a>';      

      echo "<tr>
              <td class=\"date\">".$date."</td>
              <td class=\"subj".$unseen."\">".$subj."</td>
              <td class=\"from\">".$from."</td>
           </tr>";
    }
  }
  #Weitere Mails anzeigen
  if (($hstart + 50) < $anz) {
    $von = $hstart + 51; 
    $bis = ($anz >= ($hstart + 100)) ? ($hstart + 100) : $anz;
    echo '<tr>
            <th colspan="3" class="hstart">
             <a href="index.php?factive='.$factive.'&hstart='.($von - 1).'"> Email '.$von.' bis '.$bis.'</a>
            </th>
         </tr>';
  }


  echo '</tbody>
      </table>
</div>';


  #Die eine Email laden
  echo "<div class=\"msg\" id=\"msg\" style=\"display:$display;\">";
  if ($msg != 'nomail'){
    $header = imap_headerinfo($mbox2, $msg);
    $body = imap_body($mbox2, $msg);

    echo imap_qprint($body);
  }

?>

  <input type="button" id="close" value="Schlie&szlig;en" original-title onClick="document.getElementById('msg').style.display='none';"></input>
  </div>




<?php 
  if ($mbox){	
    imap_close($mbox); 
  }
  if ($mbox2){
    imap_close($mbox2);
  }
?>
