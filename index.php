<?php
// Init owncloud
require_once('../../lib/base.php');

OC_Util::checkLoggedIn();
OC_Util::checkAppEnabled('email'); 

require( 'template.php' );

include 'template/functions.php';

#Navigation anzeigen
OC_App::setActiveNavigationEntry('email_index');

# Style hinzufuegen
OC_Util::addStyle('email','styles');

#Daten laden

$uid = OC_User::getUser();
$query=OC_DB::prepare("SELECT * FROM *PREFIX*email_connection WHERE uid='".$uid."'");
$data=$query->execute(array('bar'))->fetchAll();
$mailuser=$data[0]['mailuser']; 
$mailhost=$data[0]['mailhost'];
$mailpwd=$data[0]['mailpwd'];

# Welche Seite soll geladen werden?
$templates = array("index","config");
$t=$_GET['t'];
if ( in_array($t, $templates) ) {
  $template = $_GET['t'];
} else {
  $template = "index";
}

# Aktive Postfach, wenn nicht gesetzt, dann 0 (das erste)
$factive = isset($_GET['factive']) ? $_GET['factive'] : 0;

# Welche Header sollen angezeigt werden (ab welcher Mail)
$hstart  = isset($_GET['hstart']) ? $_GET['hstart'] : 0;

# Anzuzeigende Email
$msg  = isset($_GET['msg']) ? $_GET['msg'] : 'nomail';


$tmpl = new OC_TEMPLATE( "email", $template, "user" );
$tmpl->assign( "uid",  $uid);
$tmpl->assign( "mailuser",  $mailuser);
$tmpl->assign( "mailhost",  $mailhost);
$tmpl->assign( "mailpwd",  $mailpwd);
$tmpl->assign( "factive",  $factive);
$tmpl->assign( "hstart",  $hstart);
$tmpl->assign( "msg",  $msg);
$tmpl->printPage();
?>
