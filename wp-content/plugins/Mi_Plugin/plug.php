<?php

/*
Plugin Name : [MyPlugIN],
Descripcion: [My First PlugIn], Author: [Yaview Raymundo Lomelí Sánchez],
Version: 1.0.0,
Date: [15/03/2018]
*/

function saludar1(){
  echo '<h1>Hola </h1>';
}

function saludar2(){
  echo '<h1>Mi Nombre es: </h1>';
}

function saludar3($nombre){
  echo '<h1>'.$nombre.' </h1>';
}


$name = 'Yaview Lomeli';

add_action('Saludo_1',saludar1(),[1]);
add_action('Saludo_2',saludar2(),[2]);
add_action('Saludo_3',saludar3($name),[10]);

?>
