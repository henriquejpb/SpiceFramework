<?php
/**
 * @author Henrique Barcelos <rick.hjpbarcelos@gmail.com>
 * @copiright (c) 2013, Henrique Barcelos
 */

ini_set('display_errors', true);
error_reporting(E_ALL | E_STRICT);

setlocale(LC_ALL, array('es_ES', 'es_ES.iso-8859-1', 'es_ES.utf-8', 'spanish'));
ini_set('date.timezone', 'Europe/Madrid');

if(!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
}

set_include_path(
    implode(PATH_SEPARATOR,
        array_unique(
            array_merge(
                array(
                    APP_ROOT . 'src', 
                    APP_ROOT . 'tests/unit'
                ),
                explode(PATH_SEPARATOR, get_include_path())
            )
        )
    )
);

spl_autoload_register(
    function ($class) {
        $file = sprintf(
            "%s.php", 
            str_replace('\\', DIRECTORY_SEPARATOR, $class)
        );

        if (($classPath = stream_resolve_include_path($file)) != false) {
            require $classPath;
        }
    }
, true);
