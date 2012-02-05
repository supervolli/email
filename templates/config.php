<?php
$uid = $_['uid'];
$mh = $_['mailhost'];
$mu = $_['mailuser'];
$mp = $_['mailpwd'];
echo $mh;
?>
<form id="emailform">
  <fieldset class="personalblock">
    <strong>Emaileinstellungen</strong>
    <br>
    <label for="mh">IMAP-Server</label>
    <input type="text" name="mh" id="mh" value="<?php echo $mh; ?>" placeholder="IMAP-Server" original-title="">
    <br>
    <label for="mu">Benutzername</label>
    <input type="text" name="mu" id="mu" value="<?php echo $mu; ?>" placeholder="Benutzername" original-title="">
    <label for="mp">Passwort</label>
    <input type="password" name="mp" id="mp" value="" placeholder="Passwort" original-title="">   
  </fieldset>
</form>

