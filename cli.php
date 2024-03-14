<?php

function createController($nameController, $fluxo)
{
  $class              = ucfirst($nameController) . "Controller";
  $fluxo              = ucfirst($fluxo);
  $controllerFileName = __DIR__ . "/module/{$fluxo}/src/Controller/{$class}.php";

  if(file_exists($controllerFileName))
  {
    echo "O controller '$controllerFileName' já existe.\n";

    exit(1);
  }

  $controllerContent = <<<PHP
  <?php

  namespace $fluxo\Controller;

  use Laminas\Mvc\Controller\AbstractActionController;
  use Laminas\View\Model\ViewModel;

  class $class extends AbstractActionController
  {
    public function indexAction()
    {
      return new ViewModel();
    }
  }
  PHP;

  file_put_contents($controllerFileName, $controllerContent);

  echo "Controller $class criado com sucesso.\n";

  createControllerFactory($nameController, $fluxo);
}

function createControllerFactory($nameController, $fluxo)
{
  $class              = ucfirst($nameController) . "ControllerFactory";
  $controller         = ucfirst($nameController) . "Controller";
  $fluxo              = ucfirst($fluxo);
  $controllerFileName = __DIR__ . "/module/{$fluxo}/src/Controller/Factory/{$class}.php";

  if(file_exists($controllerFileName))
  {
    echo "O factory $controllerFileName já existe.\n";

    exit(1);
  }

  $controllerFactoryContent = <<<PHP
  <?php

  namespace $fluxo\Controller\Factory;

  use Interop\Container\ContainerInterface;
  use Laminas\ServiceManager\Factory\FactoryInterface;
  use $fluxo\Controller\\$controller;

  class $class implements FactoryInterface
  {
    public function __invoke(ContainerInterface \$container, \$requestedName, array \$options = null)
    {
      return new $nameController();
    }
  }
  PHP;

  file_put_contents($controllerFileName, $controllerFactoryContent);
  
  echo "ControllerFactory $class criado com sucesso.\n";
}

function createModel($nameModel, $fluxo)
{
  $class              = ucfirst($nameModel) . "Manager";
  $fluxo              = ucfirst($fluxo);
  $modelFileName = __DIR__ . "/module/{$fluxo}/src/Service/{$class}.php";

  if(file_exists($modelFileName))
  {
    echo "O model '$modelFileName' já existe.\n";

    exit(1);
  }

  $modelContent = <<<PHP
  <?php

  namespace $fluxo\Service;

  use Laminas\Db\Sql\{Sql, Where, Expression};
  use Laminas\Paginator\Paginator;
  use Laminas\Paginator\Adapter\DbSelect;

  class $class
  {
    private \$bd;

    public function __construct(Db \$db)
    {
      \$this->bd = \$db->bd;
    }
  }
  PHP;

  file_put_contents($modelFileName, $modelContent);

  echo "Model $class criado com sucesso.\n";

  createModelFactory($nameModel, $fluxo);
}

function createModelFactory($nameModel, $fluxo)
{
  $class         = ucfirst($nameModel) . "ManagerFactory";
  $model         = ucfirst($nameModel) . "Manager";
  $fluxo         = ucfirst($fluxo);
  $modelFileName = __DIR__ . "/module/{$fluxo}/src/Service/Factory/{$class}.php";

  if(file_exists($modelFileName))
  {
    echo "O factory $modelFileName já existe.\n";

    exit(1);
  }

  $modelFactoryContent = <<<PHP
  <?php

  namespace $fluxo\Service\Factory;

  use Interop\Container\ContainerInterface;
  use Laminas\ServiceManager\Factory\FactoryInterface;
  use $fluxo\Service\\$model;

  class $class implements FactoryInterface
  {
    public function __invoke(ContainerInterface \$container, \$requestedName, array \$options = null)
    {
      \$db = \$container->get(Db::class);

      return new $model(\$db);
    }
  }
  PHP;

  file_put_contents($modelFileName, $modelFactoryContent);
  
  echo "ManagerFactory $class criado com sucesso.\n";
}

$options = getopt("hc:m:f:");

if(array_key_exists("h", $options))
{
  echo "Modo de Uso: php cli.php -c <nome_do_controller>\n";

  exit(0);
}

if(!isset($options['c']) && !isset($options['m']))
{
  echo "Para criação do Controller. Use -c <nome_do_controller>\n";
  echo "Para criação do Model. Use -m <nome_do_manager>\n";

  exit(1);
}

if(!isset($options['f']))
{
  echo "Nome do Fluxo não Especificado. Use -f <nome_do_fluxo>\n";

  exit(1);
}

if(isset($options['c']) && !empty($options['c']))
{
  createController($options['c'], $options['f']);
}

if(isset($options['m']) && !empty($options['m']))
{
  createModel($options['m'], $options['f']);
}

