<?php
# Hier werden die Ordner des Emailaccounts geladen
# und angezeigt. Das Target ist <div id="leftcontent">
require_once('../../../lib/base.php');

OC_Util::checkLoggedIn();
OC_Util::checkAppEnabled('email');

# Email Konfigurtion laden
$folder = $_GET['folder']; # zu oeffnendes Postfach
$offset = $_GET['offset']; # ab welcher Mail soll geladen werden

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

# Anzahl der Emails
$anzahl = imap_num_msg( $mbox );

echo '<ul>';

for ( $i=$offset; $i < ( $offset + 30 ); $i++ ){
	# Header einer Mail laden
	$header = imap_headerinfo( $mbox,( $anzahl - $i ), 20, 100 );
    if ( $header ) {
		# Fremdcode Test Codierung Herausbekommen
        if(ereg("=?utf-8",strtolower($header->subject))){ 
            $subject = utf8_decode(imap_utf8($header->subject)); 
            $subject = htmlentities($subject); 
            $from    = $header->fromaddress;     
        } 
        elseif(ereg("=?iso-8859-1",strtolower($header->subject))){ 
            $subject = utf8_decode(imap_utf8($header->subject)); 
            $subject = htmlentities($subject); 
            $from    = $header->fromaddress; 
        } 
        elseif(ereg("=?us-ascii",strtolower($header->subject))){ 
            //$subject = imap_mime_header_decode($header->subject); 
            $subject = utf8_decode(imap_utf8($header->subject)); 
            $subject = htmlentities($subject); 
            //    print_r($header); 
        } 
        else{ 
            $subject = $header->subject; 
            $from    = $header->fromaddress; 
        }    	
    	# Ende
 #   	$subject = imap_utf8( $header->subject );
		# Mail von heute?
		$datetmp = $header->udate;
		$date = ( date("d M Y") == date("d M Y", $datetmp) ) ? date( "H:m", $datetmp ) : date( "d.m.y", $datetmp );
 #		$from = trim(imap_utf8( $header->fetchfrom ));
		$message_id = $header->message_id;
		$unseen = $header->Unseen;
		$flagged = $header->Flagged;
		$answered = $header->Answered;
		# Nicht gesehene Mail
		$unseen = ( $unseen == 'U' ) ? ' header_new' : '';
		# Body Auszug laden
		$body = imap_body($mbox, ( $anzahl - $i ), 1.1, 2);
		# Ausgabe eines Headers
		echo '<li class="header'.$unseen.'">';
		echo '<b>'.$date.'&nbsp;&nbsp;&nbsp;'.$from.'</b><br>';
		echo '<span class="header_subject>"'.$subject.'</span><br>';
		echo '<span class="header_body">'.$body.'</span>';
		echo '</li>';
    }
}

# Noch weitere Mails zum Laden da?
if ( ($offset + 30) < $anzahl ) {
   	echo '<li id="mehrmails" class="mehrmails">';
   	echo '    Weitere Mails laden'; 
   	echo '</li>';
}

if( $mbox ) {
  imap_close( $mbox );	
}
?>