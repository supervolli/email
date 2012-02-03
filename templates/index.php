<?php 
$uid = $_['uid'];
$mh = "{".$_['mailhost'].":143/novalidate-cert}";
$mu = $_['mailuser'];
$mp = $_['mailpwd'];
#Mailbox öffnen
$mbox = imap_open($mh."INBOX", $mu, $mp);
echo imap_last_error();

if ($mbox){
	#Ordner laden
	$folders = imap_list($mbox, $mh, "*");
	#Mailbox schließen   
} else {
	echo "Oeffnen des Postfaches fehlgeschlagen.";
	echo imap_last_error();
}

?>
<div id="controls">
<!--<b>Konfiguration</b><br />-->
<input type="button" id="email_new" value="Neue Email" original-title></input>
<input type="button" id="email_config" value="Konfigurieren" original-title></input>
<?php
#    echo "uid $uid<br />";
#    echo "Host ".$_['mailhost']."<br />";
#    echo "User $mu<br />";
?>
</div>

<div id="leftcontent" class="leftcontent">
<?php
if ($folders == false) {
    echo "Abruf fehlgeschlagen<br />\n";
} else {
    echo "<ul id=\"contacts\"><li><b>Ordner</b></li>";
    foreach ($folders as $val) {
        echo "<li>".$val."</li>";
    }
    echo "</ul>";
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
