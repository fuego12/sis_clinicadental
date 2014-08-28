<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['about'] = "home/about";
$route['services'] = "home/services";
$route['contact'] = "home/contact";
$route['login'] = "home/login";
$route['close'] = "home/close";
$route['medico'] = "usuario/medico";
$route['paciente'] = "usuario/paciente";
$route['odontograma'] = "odontograma";
$route['update_diente_estado'] = "odontograma/update_diente_estado";
$route['update_diente_enfermedad'] = "odontograma/update_diente_enfermedad";
$route['historia_paciente'] = "odontograma/historia_paciente";
$route['abrir_cita'] = "odontograma/abrir_cita";
$route['cerrar_cita'] = "odontograma/cerrar_cita";
$route['insert_procedimiento'] = "odontograma/insert_procedimiento";
$route['procedimiento'] = "procedimientos/procedimiento";
$route['clinica'] = "clinica";


$route['default_controller'] = "home/login";
$route['404_override'] = '';