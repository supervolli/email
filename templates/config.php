<?php

$uid = OC_User::getUser();
$query=OC_DB::prepare("SELECT * FROM *PREFIX*email_connection WHERE uid='".$uid."'");
$data=$query->execute(array('bar'))->fetchAll();
$mailuser=$data[0]['mailuser']; 
$mailhost=$data[0]['mailhost'];
$mailpwd=$data[0]['mailpwd'];

echo $mh;
?>
<form id="emailform">
  <fieldset class="personalblock">
    <strong>Emaileinstellungen</strong>
    <br>
    <label for="mh">IMAP-Server</label>
    <input type="text" name="mh" id="mh" value="<?php echo $mailhost; ?>" placeholder="IMAP-Server" original-title="">
    <br>
    <label for="mu">Benutzername</label>
    <input type="text" name="mu" id="mu" value="<?php echo $mailuser; ?>" placeholder="Benutzername" original-title="">
    <label for="mp">Passwort</label>
    <input type="password" name="mp" id="mp" value="" placeholder="Passwort" original-title="">   
  </fieldset>
</form>

