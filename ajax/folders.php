<?php
# Hier werden die Ordner des Emailaccounts geladen
# und angezeigt. Das Target ist <div id="leftcontent">
require_once('../../../lib/base.php');

OC_Util::checkLoggedIn();
OC_Util::checkAppEnabled('email');

# Email Konfigurtion laden 
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

$serverstring = '{'.$mailhost.':'.$mailport.'/imap'.$mailssl.'/novalidate-cert}INBOX';

# Postfaecher abfragen
$mbox = imap_open( $serverstring, $mailuser, $mailpwd );
if ( $mbox ){
  $folders = imap_getmailboxes($mbox, '{'.$mailhost.'}', '*');
  sort( $folders );
}

echo '  <li class="folder_head">Postf&auml;cher --- reload</li>';

# Postfaecher einzelnd ausgeben
foreach ($folders as $key=>$val){
  # Postfachnamen bearbeiten
  $folder = str_replace('{'.$mailhost.'}','',imap_utf7_decode($val->name));
	  $tmpfolder = $folder; # wird f�r den String unten ben�tigt
	  $tmpfolder = str_replace( 'INBOX', '', $tmpfolder );
  $folder = ( $folder=='INBOX' ) ? 'Posteingang' : $folder;
  $folder = str_replace( 'INBOX.', '', $folder );
  # Postfachstatus abfragen unseen->ungesehene Nachrichten
  $status = imap_status($mbox, $val->name, SA_ALL);
  $unseen = ( $status->unseen <> '0' ) ? " (<b>".$status->unseen."</b>)" : '' ;
  # Postfacheintrag ausgeben
  echo '  <li class="folder" id="folder">';
  echo '    <input type="hidden" name="folder" value="'.$serverstring.$tmpfolder.'">';
  echo '    '.$folder.$unseen;
  echo '  </li>';
}

($mbox) ? imap_close( $mbox ) : '';
?>