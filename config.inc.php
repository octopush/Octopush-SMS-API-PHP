<?php

/**
 * SMS Sending Library by POST HTTP
 *
 * Author Yoni Guimberteau yoni@octopush.com
 *
 * copyright (c) 2014 Yoni Guimberteau
 * licence : use, edit, sell.
 * L'auteur ainsi se decharge de toute responsabilite
 * concernant une quelconque utilisation de ce code, livre sans aucune garantie.
 * Il n'est distribue qu'a titre d'exemple de fonctionnement du module POST HTTP de OCTOPUSH,
 * Vous pourrez toutefois telecharger une version actualisee sur www.octopush.com
 */

define('DOMAIN', 'https://www.octopush-dm.com');
define('PORT', '80');
define('PATH', '');
define('PATH_BIS', '');
$path = PATH;

define('PATH_SMS', $path . '/api/sms');
define('PATH_BALANCE', $path . '/api/balance');

define('_CUT_', 8);

define('SMS_WORLD', 'WWW');
define('SMS_LOWCOST_FRANCE', 'XXX');
define('SMS_PREMIUM_FRANCE', 'FR');
?>