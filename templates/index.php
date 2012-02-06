<div id="controls">
	<input type="button" id="email_new" value="Neue Email"></input>
</div>
<div id="folders">folders</div>

<script type="text/javascript">
<!--
/* Erstes Laden der Ordner */
$.ajax({
	  url: "ajax/folders.php",
	  cache: false,
	  dataType: "text";
	  success: function( folders ){
	    $("#folders").html( folders );
	  },
	  error: function ( error ) {
		alert( error )
	  } 
	});
//-->
</script>

<div id="headersdiv">
	<ul id="headers">&nbsp;</ul>
</div>

<?php 
#      <div id="rightcontent" class="rightcontent">';
 
#  $folder = $folders[$factive]->name;
  #echo $folder;

  #2. Verbindung nur fuer den aktiven Ordner
#  $mbox2 = imap_open($folder,$mu,$mp);

#  $anz = imap_num_msg($mbox2);

#  echo '<table class="headers">';
#  echo '<thead>
#         <tr>
#           <th style="width: 100px;">Datum</th>
#           <th>Betreff</th>
#           <th style="width: 120px;">Von</th>
#         </tr>
#       </thead>
#       <tbody>';
#  # vorherige Mails
#  if ($hstart > 49) {
#    $von = ($hstart > 50)? ($hstart - 50) : 1;
#    $bis = $hstart -1;
#    echo '<tr>
#            <th colspan="3" class="hstart">
#              <a href="index.php?factive='.$factive.'&hstart='.($von - 1).'">Email '.$von.' bis '.$bis.'</a>
#          </th>
#         </tr>';
#  }  

  #Headers $hstart + 25
#  for ($i=$hstart; $i < ($hstart + 50); $i++){
#    $header = imap_headerinfo($mbox2,($anz - $i), 20, 100); 
#    if ($header){
#      $subj = imap_utf8($header->subject);
#      $date = date("d. M Y H:m",$header->udate);
#      $from = imap_utf8($header->fetchfrom);
#      $msgno = trim($header->Msgno);
#      $unseen = $header->Unseen;

      # Email Link zum oeffnen
#      $subj = 'onclick="window.open(\'\', \'popup\', \'width=800,height=600,scrollbars=yes, toolbar=no,status=no, resizable=yes,menubar=no,location=no,directories=no\')" href="msg.php?msg='.$msgno.'">'.$subj.'</a>';      

#      echo "<tr>
#              <td class=\"date\">".$date."</td>
#              <td class=\"subj".$unseen."\">".$subj."</td>
#              <td class=\"from\">".$from."</td>
#           </tr>";
#    }
#  }
  #Weitere Mails anzeigen
#  if (($hstart + 50) < $anz) {
#    $von = $hstart + 51; 
#    $bis = ($anz >= ($hstart + 100)) ? ($hstart + 100) : $anz;
#    echo '<tr>
#            <th colspan="3" class="hstart">
#             <a href="index.php?factive='.$factive.'&hstart='.($von - 1).'"> Email '.$von.' bis '.$bis.'</a>
#            </th>
#         </tr>';
#  }


#  echo '</tbody>
#      </table>
#  </div>';

  
#  if ($mbox){	
#    imap_close($mbox); 
#  }
#  if ($mbox2){
#    imap_close($mbox2);
#  }
?>
