<?php
@session_start();
header ('Content-type: text/html; charset=utf-8');

/**
 * @Global conts
 */

/**
 * info about current page, example: index.php
 * @var string
 */
$page = curPage();

/**
 * inicializa la database
 */
//if(USE_DB)
	$obj = new db();
