<?php

$uid = OC_User::getUser();
$query=OC_DB::prepare("SELECT * FROM *PREFIX*email_connection WHERE uid='".$uid."'");
$data=$query->execute(array('bar'))->fetchAll();
$mailuser=$data[0]['mailuser']; 
$mailhost=$data[0]['mailhost'];
$mailpwd=$data[0]['mailpwd'];
$mailport=$data[0]['mailport'];
$mailssl = ($data[0]['mailssl']) ? 'checked' : '';

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
    <br>
    <label for="mport">Port</label>
    <input type="text" name="mport" id="mport" value="<?php echo $mailport; ?>" placeholder="993" original-title="">
    <label for="mssl">SSL</label>
    <input type="checkbox" name="mssl" id="mssl" "<?php echo $mssl; ?>" original-title="">
  </fieldset>
</form>

