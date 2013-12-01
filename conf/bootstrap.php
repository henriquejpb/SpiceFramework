<?php
/**
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 * @copyright (c) 2013, Henrique Barcelos
 */

ini_set('display_errors', true);
error_reporting(E_ALL | E_STRICT);

setlocale(LC_ALL, array('pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese'));
ini_set('date.timezone', 'America/Sao_Paulo');

if(!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}

require APP_ROOT.'vendor/autoload.php';
