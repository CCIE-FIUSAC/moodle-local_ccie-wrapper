<?php
require_once('curl.php');
/*
* Envoltorio PHP del cliente para el servicio web 'local_ccie'.
* Encapsula las llamadas HTTP y el formato del contenido en transferencia
*/
class Matriculacion {
  // Protocolo HTTP o HTTPS
  private $protocol='https';
  // Ubicacion de la plataforma moodle
  private $domain='uedi.ingenieria.usac.edu.gt/campus';
  // Token asignado por moodle para acceder al servicio 'local_ccie'
  private $token='ba95d022d3a6b2a5d812acab028e92a9';
  // Formato del contendo transferido
  private $rest_format='json';

  /*
  * Devuelve ubicacion del recurso local_ccie_$funcion del campus virtual
  * @param $funcion funcion del recurso del campus virtual
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
  *  'password' Contraseña del usuario. Si se utiliza el pin, la política de contraseñas seguras de moodle debe estar desactivado. No enviar si se utiliza SSO
  *  'email' Correo electrónico del usuario
  *  'roleid' Role que tiene el usuario con el curso. Valores: 3 (editingteacher), 4 (teacher), 5 (student)
  *  'idnumbers' Array donde cada elemento es un ID Number que representa el curso en moodle
  * @return Estructura con los siguientes elementos:
  *  'statusCode' 200 indica exito, cualquier otro valor es fracaso
  *  'message' Informacion acerca del estado
  *  'username' Identificador único del usuario moodle (Usualmente el carné del estudiante)
  *  'enrolments' Array de una estructura con los siguientes elementos
  *     'statusCode' 200 indica éxito, cualquier otro valor es fracaso
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
  *   'statusCode' 200 indica éxito, cualquier otro valor es fracaso
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
  * Devuelve el enlace para iniciar sesión con SSO
  * Moodle debe tener la extensión 'auth_googleoauth2' con soporte para OpenAM instalado y configurado!
  * @return String URL para iniciar sesión externo
  * @return Array de una estructura con el siguiente elemento
  *  'authurl' Enlace del SSO para iniciar sesión externo
  **/
  public function get_authurl(){
    $curl = new curl;
    $resp = $curl->post($this->get_serverurl('get_authurl'));
    return json_decode($resp);
  }
  /*
  * Cambia la contraseña de un estudiante.
  * @param username Identificador único del usuario moodle (Usualmente el carné del estudiante).
  * @param password Nueva contraseña del usuario.
  * @return Estructura con los siguientes elementos:
  *  'statusCode' 200 indica exito, cualquier otro valor es fracaso
  *  'message' Informacion acerca del estado
  */
  public function set_password($username, $password){
    $curl = new curl;
    $resp = $curl->post($this->get_serverurl('set_password'), array('username'=>$username, 'password'=>$password));
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
