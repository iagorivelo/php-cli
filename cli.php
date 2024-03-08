<?php

if($argc < 2)
{
  echo "Modo de Uso: php cli.php <nome_do_controller>\n";

  exit(1);
}

$controllerName     = $argv[1];
$controllerFileName = ucfirst($controllerName) . 'Controller.php';
