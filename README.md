# moodle-local_ccie-wrapper
PHP client wrapper for moodle-local_ccie web service

# Configuración
En `class.matriculacionElearning.inc.php` modificar las siguientes varaibles con un valor adecuado:
* `$protocol` con `https` o `http` (en desarrollo).
* `$domain` nombre de dominio de la instancia Moodle.
* `$token` credencial válido para la instsancia Moodle.
* `$rest_format` con `json`.

# Uso
Importar la clase `Matriculacion` para una instancia
```php
require_once('./class.matriculacionElearning.inc.php');
$uedi = new Matriculacion;
```
# Funciones
* `$uedi->hello_world` recurso de prueba de web service de moodle
* `$uedi->matricular` matricula un estudiante con los cursos especificados.
* `$uedi->desmatricular` desmatricula un estudiante de TODOS los cursos en moodle, sin eliminar su progreso dentro de la misma.
* `$uedi->get_cursos` devuelve un listado de cursos disponibles
* `$uedi->get_authurl` devuelve el enlace para iniciar sesión con SSO
* `$uedi->set_password` Cambia la contraseña de un estudiante

> NOTA: para mayor información, ver comentarios en `class.matriculacionElearning.inc.php`
