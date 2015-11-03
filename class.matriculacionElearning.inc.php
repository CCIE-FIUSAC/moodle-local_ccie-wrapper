<?php
require_once('curl.php');
/*
* Envoltorio PHP del cliente para el servicio web 'local_ccie'.
* Encapsula las llamadas HTTP y el formato del contenido en transferencia
*/
class Matriculacion {
  // Protocolo HTTP o HTTPS
  private $protocol='http';
  // Ubicacion de la plataforma moodle
  private $domain='uedi.ingenieria.usac.edu.gt/campus';
  // Token asignado por moodle para acceder al servicio 'local_ccie'
  private $token='ba95d022d3a6b2a5d812acab028e92a9';
  // Formato del contendo transferido
  private $rest_format='json';

  /*
  * Devuelve ubicacion del recurso elearning local_ccie_$funcion
  * @param $funcion funcion del recurso elearning
  */
  protected function get_serverurl($funcion){
    return $this->protocol.'://'.$this->domain.'/webservice/rest/server.php?wstoken='.$this->token.'&wsfunction=local_ccie_'.$funcion.'&moodlewsrestformat='.$this->rest_format;
  }
  /*
  * Matricula un estudiante con los cursos especificados.
  * @param $params estructura con los siguientes elementos:
  *  'username' Identificador único del usuario moodle (Usualmente el carné del estudiante)
  *  'firstname' Primer y segundo nombre del usuario
  *  'lastname' Apellidos del usuario
  *  'password' Contraseña del usuario (Opcional)
  *  'email' Correo electrónico del usuario
  *  'roleid' Role que tiene el usuario con el curso. Valores: 3 (editingteacher), 4 (teacher), 5 (student)
  *  'idnumbers' Array donde cada elemento es un ID Number que representa el curso en moodle
  * @return Estructura con los siguientes elementos:
  *  'statusCode' 0 para exito, cualquier otro valor es fracaso
  *  'message' Informacion acerca del estado
  *  'username' Identificador único del usuario moodle (Usualmente el carné del estudiante)
  *  'enrolments' Array de una estructura con los siguientes elementos
  *     'statusCode' 0 para exito, cualquier otro valor es fracaso
  *     'message' Informacion acerca del estado
  *     'courseid' ID Number que representa el curso en moodle
  */
  public function matricular(array $params){
    $curl = new curl;
    $resp = $curl->post($this->get_serverurl('matricular'), $params);
    return json_decode($resp);
  }
  /*
  * Desmatricula un estudiante de TODOS los cursos en moodle, sin eliminar su progreso dentro de la misma.
  * @param username Identificador único del usuario moodle (Usualmente el carné del estudiante)
  * @param idnumbers Array donde cada elemento es un ID Number que representa el curso en moodle
  * @return Estructura con los siguientes elementos
  *   'statusCode' 0 (Exito) o 1 (fracaso)
  *   'message' Breve descripción del resultado
  *   'username' Identificador único del usuario moodle (Usualmente el carné del estudiante)
  */
  public function desmatricular($username, array $idnumbers=array()){
    $curl = new curl;
    $resp = $curl->post($this->get_serverurl('desmatricular'), array('username'=>$username, 'idnumbers'=>$idnumbers));
    return json_decode($resp);
  }
  /*
  * Devuelve un listado de cursos disponibles
  * @return Array de una estructura con los siguientes elementos
  *  'fullname' Nombre completo del curso
  *  'shortname' Nombre cordo del curso
  *  'idnumber' Identificador único del curso
  *  'matriculado' 0 (matriculado), 1 (no matriculado)
  */
  public function get_cursos($username = null){
    $curl = new curl;
    $resp = $curl->post($this->get_serverurl('get_cursos'), array('username'=>$username));
    return json_decode($resp);
  }
  /**
  * Recurso de prueba de web service de moodle
  **/
  public function hello_world(){
    $curl = new curl;
    $resp = $curl->post($this->get_serverurl('hello_world'),
            array('welcomemessage' => 'Bienvenido, ')
          );
    return json_decode($resp);
  }
}
