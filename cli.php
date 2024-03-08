<?php

$options = getopt("hc:");

if(array_key_exists("h", $options))
{
  echo "Modo de Uso: php cli.php -c <nome_do_controller>\n";

  exit(0);
}

if(!isset($options['c']))
{
  echo "Nome do controller não especificado. Use -c <nome_do_controller>\n";

  exit(1);
}

$controllerName     = $options['c'];
$controllerFileName = ucfirst($controllerName) . 'Controller.php';

if(file_exists($controllerFileName))
{
  echo "O controller '$controllerName' já existe.\n";

  exit(1);
}

$nameController = ucfirst($controllerName) . "Controller";

$controllerContent = <<<PHP
<?php

namespace {Diretorio do Controller}\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class $nameController extends AbstractActionController
{
  public function indexAction()
  {
    return new ViewModel();
  }
}
PHP;

file_put_contents($controllerFileName, $controllerContent);

echo "Controller '$controllerName' criado com sucesso.\n";
