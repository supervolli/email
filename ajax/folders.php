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

echo '<ul>';
echo '  <li class="folder_head">Postf&auml;cher --- reload</li>';
# Postfaecher ausgeben
foreach ($folders as $key=>$val){
  echo '  <li>'.$key->name.'</li>';
}
echo '</ul>';

($mbox) ? imap_close( $mbox ) : '';
?>