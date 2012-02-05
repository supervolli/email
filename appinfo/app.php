<?php

OC_APP::register( array( "order" => 2, "id" => "email", "name" => "Email" ));

OC_APP::addNavigationEntry( array( "id" => "email_index", 
                                   "order" => 2, 
                                   "href" => OC_HELPER::linkTo( "email", "index.php" ), 
                                   "icon" => OC_HELPER::imagePath( "email", "icon.png" ), 
                                   "name" => "Email" ));

OC_APP::registerPersonal('email','config');

?>
