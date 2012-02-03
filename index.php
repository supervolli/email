<?php
// Init owncloud
require_once('../../lib/base.php');
require( 'template.php' );

$version=OC_APPCONFIG::getValue('email','installed_version',0);
if($version!=0){
	
	#$query=OC_DB::prepare("SELECT foo_value FROM *PREFIX*test_dummy WHERE foo_name=?");
	#$data=$query->execute(array('bar'))->fetchAll();
	#$bar=$data[0]['foo_value'];
	$uid = OC_User::getUser();
	$query=OC_DB::prepare("SELECT * FROM *PREFIX*email_connection WHERE uid='".$uid."'");
	$data=$query->execute(array('bar'))->fetchAll();
	$mailuser=$data[0]['mailuser']; 
	$mailhost=$data[0]['mailhost'];
	$mailpwd=$data[0]['mailpwd'];
	$uid = OC_User::getUser();
}else{
	$bar=0;
}

# Aktive Postfach, wenn nicht gesetzt, dann 0 (das erste)
$factive = isset($_GET['factive']) ? $_GET['factive'] : 0;

# Welche Header sollen angezeigt werden (ab welcher Mail)
$hstart  = isset($_GET['hstart']) ? $_GET['hstart'] : 0;

$tmpl = new OC_TEMPLATE( "email", "index", "user" );
$tmpl->assign( "uid",  $uid);
$tmpl->assign( "mailuser",  $mailuser);
$tmpl->assign( "mailhost",  $mailhost);
$tmpl->assign( "mailpwd",  $mailpwd);
$tmpl->assign( "factive",  $factive);
$tmpl->assign( "hstart",  $hstart);
$tmpl->printPage();
?>
