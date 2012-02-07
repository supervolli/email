<?php

function getBody( $mbox, $msgno ){
	$body = 'empty';
	
	$struct  = imap_fetchstructure( $mbox, $msgno );
	$encode  = $struct->encoding;
	$type    = $struct->type;
	$subtype = ( $struct->ifsubtype ) ? $struct->subtype : 'text';
	
	
	if ($type==0){ # Text
		$body = imap_fetchbody( $mbox, $msgno, 0, 2 );
		switch ($encode){
			case 3: 
				$body = base64_decode($body);
			    break;
			case 4: 
				$body = quoted_printable_decode($body);
			    break;
		}
		$body = 'text';		
	} else {       # Multipart
		
		$body = 'multipart';
	}
	
	return $body;
}


?>