<?php
require_once('./class.matriculacionElearning.inc.php');
$uedi = new Matriculacion;
//print_r($uedi->hello_world());
//return;
// GET_AUTHURL
//$authurl = $uedi->get_authurl()->authurl;
//print_r($authurl);
//return;
// GET_CURSOS
//$cursosDisponibles = $uedi->get_cursos('201621912')->cursos;
//print_r($cursosDisponibles);
//return;
$idnumbers = array();
foreach ($cursosDisponibles as $cursoDisponible){
  $idnumbers[]= $cursoDisponible->idnumber;
  //break;
}
// $idnumbers[]= '009'; // idnumber invalido
$params = array('username' => '201621912',
'firstname' => 'Alfredo',
'lastname' => 'Alvarado',
'email' => '201621912@ingenieria.usac.edu.gt',
'roleid' => 5,
'idnumbers' => $idnumbers
);
// MATRICULAR
//$respuesta = $uedi->matricular($params);
//print_r($respuesta);
//return;
// DESMATRICULAR
//$respuesta = $uedi->desmatricular('201621912', array('0017A+')); // idnumber invalido
$respuesta = $uedi->desmatricular('201621912', $idnumbers);
print_r($respuesta);
