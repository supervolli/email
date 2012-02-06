<?php
# Hier werden die Ordner des Emailaccounts geladen
# und angezeigt. Das Target ist <div id="leftcontent">
require_once('../../../lib/base.php');

OC_Util::checkLoggedIn();
OC_Util::checkAppEnabled('email');

# Email Konfigurtion laden
$folder = $_GET['folder']; # zu oeffnendes Postfach
$offset = $_GET['offset']; # ab welcher Mail soll geladen werden

echo $folder.' '.$offset;

$uid = OC_User::getUser();
$query = OC_DB::prepare("SELECT * FROM *PREFIX*email_connection WHERE uid='".$uid."'");
$data = $query->execute(array('bar'))->fetchAll();

$mailuser = $data[0]['mailuser']; 
$mailhost = $data[0]['mailhost'];
$mailpwd  = $data[0]['mailpwd'];
$mailport = $data[0]['mailport'];
$mailssl  = $data[0]['mailssl'];

# Wird SSL benutzt?
$mailssl = ( $mailssl ) ? '/ssl' : '';

# Ausgewaehltes Postfach öffnen und Header laden
$mbox = imap_open( $folder, $mailuser, $mailpwd );

# Anzahl der Emails
#$anzahl = imap_num_msg( $mbox );


#for ($i=0; $i < 20; $i++){
#	$header = imap_headerinfo($mbox,($anzahl - $i), 20, 100);
#	$subject = imap_utf8($header->subject);
#	$date = date("d. M Y H:m",$header->udate);
#	$from = imap_utf8($header->fetchfrom);
#	$message_id = $header->message_id);
#	$unseen = $header->Unseen;
#}

if( $mbox ) {
  imap_close( $mbox );	
}
}
?>