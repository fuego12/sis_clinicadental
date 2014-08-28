<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('show_menu')) {

    function show_menu($codi_rol = "0") {
        if ($codi_rol == "1") {
            // Menu para Administrador
            return
                    "<li>"
                    . '<a href="' . base_url() . 'citas">Citas médicas</a>'
                    . "</li>" .
                    "<li>"
                    . '<a href="' . base_url() . 'odontograma2">Historial</a>'
                    . "</li>" .
                    "<li>"
                    . '<a href="' . base_url() . 'paciente">Pacientes</a>'
                    . "</li>" .
                    "<li>"
                    . '<a href="' . base_url() . 'medico">Médicos</a>'
                    . "</li>" .
                    
                    '<li class="dropdown">' .
                    '<a href="#" class="dropdown-toggle" data-toggle="dropdown"> Ajustes <b class="caret"></b></a>' .
                    '<ul class="dropdown-menu">' .
                    
                    "<li>"
                    . '<a href="' . base_url() . 'procedimiento">Tarifas</a>'
                    . "</li>" .
                    "<li>".
                     '<a href="' . base_url() . 'cie">CIE</a>'
                    . "</li>" .
                    "<li>"
                    . '<a href="' . base_url() . 'usuario">Usuarios</a>'
                    . "</li>" .
                    "<li>".
                    "<li>"
                    . '<a href="' . base_url() . 'clinica">Clinica</a>'
                    . "</li>" .
                    
                    '</ul>' .                    
                    "</li>" .                    
                    
                    "<li>"
                    . '<a href="' . base_url() . 'close">Cerrar sesión</a>'
                    . "</li>";
        } else if ($codi_rol == "2") {
            // Menu para Usuario
            return
//                    "<li>"
//                    . '<a href="' . base_url() . 'about">Acerca de nosotros</a>'
//                    . "</li>" .
//                    "<li>"
//                    . '<a href="' . base_url() . 'services">Servicios</a>'
//                    . "</li>" .
//                    "<li>"
//                    . '<a href="' . base_url() . 'contact">Contacto</a>'
//                    . "</li>" .
//                    '<li class="dropdown">' .
//                    '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Test <b class="caret"></b></a>' .
//                    '<ul class="dropdown-menu">' .
//                    "<li>" .
//                    '<a href="' . base_url() . 'test/ancho_completo">Ancho completo</a>' .
//                    "</li>" .
//                    "<li>" .
//                    '<a href="' . base_url() . 'test/sidebar">Página con barra</a>' .
//                    "</li>" .
//                    '</ul>' .
//                    "</li>" .
                    
                    "<li>"
                    . '<a href="' . base_url() . 'citas">Citas médicas</a>'
                    . "</li>" .
                    "<li>"
                    . '<a href="' . base_url() . 'paciente">Pacientes</a>'
                    . "</li>" .
                    "<li>".
                    "<li>"
                    . '<a href="' . base_url() . 'close">Cerrar sesión</a>'
                    . "</li>";
        } else {
            return
//                    "<li>"
//                    . '<a href="' . base_url() . 'about">Acerca de nosotros</a>'
//                    . "</li>" .
//                    "<li>"
//                    . '<a href="' . base_url() . 'services">Servicios</a>'
//                    . "</li>" .
//                    "<li>"
//                    . '<a href="' . base_url() . 'contact">Contacto</a>'
//                    . "</li>" .
//                    '<li class="dropdown">' .
//                    '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Test <b class="caret"></b></a>' .
//                    '<ul class="dropdown-menu">' .
//                    "<li>" .
//                    '<a href="' . base_url() . 'test/ancho_completo">Ancho completo</a>' .
//                    "</li>" .
//                    "<li>" .
//                    '<a href="' . base_url() . 'test/sidebar">Página con barra</a>' .
//                    "</li>" .
//                    '</ul>' .
//                    "</li>" .
                    "<li>"
                    . '<a href="' . base_url() . 'login">Inicio de sesión</a>'
                    . "</li>";
        }
    }

}