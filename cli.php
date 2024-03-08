<?php

$short = 'e:';
$long  = [
  'exec:'
];

$options = getopt($short, $long);
$command = array_key_first($options);

switch ($command) {
  case 'e':
  case 'exec':
    exec("{$options[$command]}");

    break;
  
  default:
    echo 'Comando inválido.' . "\n";

    break;
}
