<?php
// Exemple de consultation du crédit SMS


require('octopush_web_services.inc.php');

$user_login = '************@********';
$api_key = '****************';

$sms = new OWS();

$sms->set_user_login($user_login);
$sms->set_api_key($api_key);

$xml = $sms->get_balance();
echo $xml;
echo '<br />';
echo '<textarea style="width:600px;height:600px;">' . $xml . '</textarea>';
?>