<?php
require_once('../../../lib/base.php');
include 'html2text.php';
include 'mail_decode.php';

OC_Util::checkLoggedIn();
OC_Util::checkAppEnabled('email');

# Email Konfigurtion laden
$folder = $_GET['folder']; # zu oeffnendes Postfach
$msgno = $_GET['msgno'];   #  welche Mail soll geladen werden

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
$mailssl = $mailssl.'/novalidate-cert';

# Ausgewaehltes Postfach öffnen und Header laden
$mbox = imap_open( $folder, $mailuser, $mailpwd );

echo getBody( $mbox, $msgno );

?>