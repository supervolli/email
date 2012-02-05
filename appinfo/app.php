<?php

OC_APP::register( array( "order" => 3, "id" => "email", "name" => "Email" ));

OC_APP::addNavigationEntry( array( "id" => "email_index", 
                                   "order" => 3, 
                                   "href" => OC_HELPER::linkTo( "email", "index.php" ), 
                                   "icon" => OC_HELPER::imagePath( "email", "icon.png" ), 
                                   "name" => $l->t('Mail') ));

OC_APP::registerPersonal('email','config');

?>
