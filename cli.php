<?php

if($argc < 2)
{
  echo "Modo de Uso: php cli.php <nome_do_controller>\n";

  exit(1);
}

$controllerName     = $argv[1];
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
