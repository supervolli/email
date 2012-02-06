<?php
  require_once('../../lib/base.php');
  OC_Util::checkLoggedIn();
  OC_Util::checkAppEnabled('email');
  
  # Variablen laden
  $uid = OC_User::getUser();
  $msg = $_GET['msg'];
  
  # Email Verbindung aus DB holen
  $query = OC_DB::prepare("SELECT * FROM *PREFIX*email_connection WHERE uid='".$uid."'");
  $data = $query->execute(array('bar'))->fetchAll();
  
  $mu = $data[0]['mailuser']; 
  $mh = $data[0]['mailhost'];
  $mp = $data[0]['mailpwd'];
  $mport = $data[0]['mailport'];
  $mssl = $data[0]['mailssl'];
  
  # SSL enabled?
  $mssl = ( $mssl ) ? '/ssl' : '' ;
  
  # Server String zusammensetzen
  $mh = '{'.$mh.':'.$mport.'imap'.$mssl.'/novalidate-cert}INBOX';
  
  $mbox = imap_open($mh, $mu, $mp);
  echo imap_last_error();
  
  
  if($mbox) {
   imap_close($mbox);
  }
?>