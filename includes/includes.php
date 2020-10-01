<?php
define("CURRENT_PATH", realpath(".") . "/");
define("SYSTEM_PATH", substr(dirname(__FILE__), 0, strrpos(dirname(__FILE__), "/") + 1));

include_once SYSTEM_PATH . 'config/config.php';
showError();

include SYSTEM_PATH . 'classes/mysql/shared/ez_sql_core.php';
include SYSTEM_PATH . 'classes/mysql/ez_sql_mysqli.php';
include SYSTEM_PATH . 'classes/class.querybuild.php';

include SYSTEM_PATH . 'includes/helpers.php';
include SYSTEM_PATH . 'includes/global.php';

if(file_exists(CURRENT_PATH . 'code_behind/' . $page))
	include CURRENT_PATH . 'code_behind/' . $page;
    
/**
 * habilita el muestreo de errores
 */
function showError(){
    if(DEBUG){
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    } else {
        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);
        error_reporting(0);
    }
}