<?php
function loginMedico(){
	global $obj;

	if( empty($_POST["login"]) ){
		return false;
	}

	$email = $_POST["email"];
	$password = $_POST["password"];

	$user = $obj->get_var("select nombre from registro where email = '{$email}' and password = '{$password}'");

	if(!empty($user)){
		$_SESSION["medico"] = $user;
		return true;
	} else
		return false;
}

function registroMedico(){
	global $obj;

	$nombre = $_POST["nombre"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$cedula = $_POST["cedula"];

	$qry = "insert into registro(nombre, email, cedula, password) values('{$nombre}', '{$email}', '{$cedula}', '{$password}')";
	$obj->query($qry);
}

function isMedico(){
	$medico = getMedico();

	if(empty($medico))
		return false;
	else
		return true;
}

function getMedico(){
	return $_SESSION["medico"];
}