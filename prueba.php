<?php
require_once('./class.matriculacionElearning.inc.php');
$matris = new Matriculacion;
// print_r($matris->hello_world());
// return;

$cursosDisponibles = $matris->get_cursos('201621912')->cursos;
// GET_CURSOS
// print_r($cursosDisponibles);
// return;
$idnumbers = array();
foreach ($cursosDisponibles as $cursoDisponible){
  $idnumbers[]= $cursoDisponible->idnumber;
  // break;
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
// $respuesta = $matris->matricular($params);
// print_r($respuesta);
// return;
// DESMATRICULAR
// $respuesta = $matris->desmatricular('201621912', array('0017A+')); // idnumber invalido
$respuesta = $matris->desmatricular('201621912', $idnumbers);
print_r($respuesta);
