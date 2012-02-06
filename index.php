<?php
# Init owncloud
require_once('../../lib/base.php');

OC_Util::checkLoggedIn();
OC_Util::checkAppEnabled('email');

require( 'template.php' );

#Navigation anzeigen
OC_App::setActiveNavigationEntry('email_index');

# Style hinzufuegen
OC_Util::addStyle('email','styles');        # Angepasste Styles
OC_Util::addScript('email', 'folders');     # Funktionen der Ordneranzeige

#Daten laden
$uid = OC_User::getUser();
$query=OC_DB::prepare("SELECT * FROM *PREFIX*email_connection WHERE uid='".$uid."'");
$data=$query->execute(array('bar'))->fetchAll();

$mailuser=$data[0]['mailuser']; 
$mailhost=$data[0]['mailhost'];
$mailpwd=$data[0]['mailpwd'];
$mailport=$data[0]['mailport'];
$mailssl=$data[0]['mailssl'];

$tmpl = new OC_TEMPLATE( "email", "index", "user" );
$tmpl->assign( "uid",  $uid);
$tmpl->assign( "mailuser",  $mailuser);
$tmpl->assign( "mailhost",  $mailhost);
$tmpl->assign( "mailpwd",  $mailpwd);
$tmpl->assign( "mailport",  $mailport);
$tmpl->assign( "mailssl",  $mailssl);
$tmpl->printPage();
?>