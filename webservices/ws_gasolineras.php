<?php
include("../includes/includes.php");

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

//include("common_files/sesion.php");

header('Content-Type: application/json');

$buscar = $_POST["buscar"]?$_POST["buscar"]:$_GET["buscar"];
//$notas = $obj->get_results("select * from nota where (id_usuario = {$_SESSION['idusuario']} and nota like '%{$buscar}%') order by fechaupdate desc");
//$notas = $obj->get_results("select * from nota where id_usuario = {$_SESSION['idusuario']} order by fechaupdate desc");
//$notas = $obj->get_results("select * from nota where order by fechaupdate desc");
//$gasolineras = $obj->get_results("select * from gasolinera left join sepomex on gasolineras.codigopostal = sepomex.codigo_postal limit 100");
if($buscar == ""){
    $gasolineras = $obj->get_results("select * from gasolinera left join sepomex on sepomex.codigo_postal = gasolinera.codigopostal limit 100");
}else{
    //$qry_search = "select * from gasolinera left join sepomex on sepomex.codigo_postal = gasolinera.codigopostal limit 100";
    //$qry_search = "select * from gasolinera left join sepomex on sepomex.codigo_postal = gasolinera.codigopostal where (gasolinera.codigopostal = '%{$buscar}%' or gasolinera.calle like '%{$buscar}%') limit 100";
    $qry_search = "select * from gasolinera left join sepomex on sepomex.codigo_postal = gasolinera.codigopostal where (gasolinera.codigopostal = '%{$buscar}%' or gasolinera.calle like '%{$buscar}%' or sepomex.estado like '%{$buscar}%' or sepomex.colonia like '%{$buscar}%' or sepomex.delegacion like '%{$buscar}%' or gasolinera.regular like '%{$buscar}%' or gasolinera.premium like '%{$buscar}%') limit 100";
    //echo $qry_search;
    $gasolineras = $obj->get_results($qry_search);
}

$JSONData = file_get_contents("php://input");
$dataObject = json_decode($JSONData);

$resultado["resultado"] = $gasolineras;


//$resultado["params"] = $_POST["data1"];
$resultado["params"] = $dataObject;

$resultado["paramsdata"] = $dataObject->data1;
//$dataObject

/*
 print_r($notas);
 
 echo "<hr />";
 
 print_r($resultado);
 
 echo "<hr />";
 
 
 echo json_encode($notas);
 
 echo "<hr />";
 */

echo json_encode($resultado);
?>