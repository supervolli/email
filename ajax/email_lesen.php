<?php
require_once('../../../lib/base.php');
#include 'html2text.php';
#include 'mail_decode.php';
include_once 'mimedecode.inc.php';
include_once 'imap.inc.php';

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
#$mailssl = ( $mailssl ) ? '/ssl' : '';
#$mailssl = $mailssl.'/novalidate-cert';

# Ausgewaehltes Postfach öffnen und Header laden
#$mbox = imap_open( $folder, $mailuser, $mailpwd );

#echo getBody( $mbox, $msgno );

	$tmp = explode( '}',  $folder );

	$imap=new IMAPMAIL;
	if(!$imap->open($mailhost,$port))
	{
		echo $imap->get_error();
		exit;
	} 

	$imap->login($mailuser,$mailpwd);
	echo $imap->error;
	$response=$imap->open_mailbox($folder);
	echo $imap->error;
	//echo $response=$imap->get_msglist();
	//echo $response=$imap->delete_message(9);
	//echo $response=$imap->rollback_delete(9);
	$response=$imap->get_message($msgno);


	///Decoding the mail	

	$mimedecoder=new MIMEDECODE($response,"\r\n");
	#$msg=$mimedecoder->get_parsed_message($uid);
	$msg=$mimedecoder->get_parsed_message();
	print_r($msg);
	//echo nl2br($response);
	echo $imap->get_error();
	$imap->close();
	//$response=$imap->fetch_mail("3","BODYSTRUCTURE");
	//print_r($response);
	//echo nl2br($response);
	//echo $imap->error;

?>