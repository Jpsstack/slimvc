# Slim in MVC #
This is a project about MVC Skeleton/Boilerplate for the [Slim Framework](http://www.slimframework.com/). 

 - [x] support multiple applications (mini-app)
 - [x] sample database for demonstration
 - [x] development environment with Vagrant

## Setup
You can  start the Skeleton with Vagrant directly or Setup the environment manually...

###  Work with Vagrant (Recommend)

#### Install Dependencies

##### Install Vagrant

First thing, you need to download vagrant setup from http://www.vagrantup.com/downloads.html, and then run it.

##### Install Oracle VirtualBox

You need now to download VirtualBox, use the following link to download the latest release of VirtualBox https://www.virtualbox.org/wiki/Downloads

#### Install the Application

```sh
  $ git clone https://github.com/zacao/slimvc.git --recurse-submodules
  $ cd slimvc
  $ vagrant up
```

Note: 
* The above vagrant up command will also trigger Vagrant to download the chef/centos-7.0 box via the specified URL. Vagrant only does this if it detects that the box doesn't already exist on your system.
* The setup will take some time to finish, take a cup of coffee and enjoy!
* When the setup is done browse to http://slimvc.dev/ in your browser, and you should have a default welcome page! You can also try other urls, such as http://slimvc.dev/v1/programmers, and http://slimvc.dev/v1/programmers/1
* You may face some errors because of VirtualBox with Windows, no problem please just re-run the installation again after few seconds as below, (if you encounter problem under Windows 10, please see this [Failed to create the host-only adapter issue for VirtualBox under Windows 10](https://www.virtualbox.org/ticket/14040) before re-run)

  ```sh
    $ vagrant reload --provision
  ```

###  Manual Setup

#### Install Composer

If you have not installed Composer, install it as following, <http://getcomposer.org/doc/00-intro.md#installation>

#### Install the Application

After you install Composer, run below command from the directory in which you want to install.

(assumed you install composer as /usr/bin/composer globally, or please replace `composer` with `php composer.phar`),

```sh
  $ composer create-project zacao/slimvc [project-name]
```

Replace `[project-name]` with the directory name of your new project, and then do as below steps:
* Set your virtual host document root.
  There are 2 general deployment scenarios if there are multiple applications(mini-app) in your project, please read [official guideline](http://docs.slimframework.com/routing/rewrite/) for Apache/Nginx configurations.
  * sub-domain: each mini-app has dedicate domain associated

    ```
    +-- public/
    |   +-- [mini-app-1]/ <-- Document root!
    |   |   +-- index.php <-- initialize Slim here!
    |   +-- [mini-app-2]/ <-- Document root!
    |   |   +-- index.php <-- initialize Slim here!
    ```

  * sub-folder: mini-apps share same domain, each mini-app works as sub-folder of this domain

    ```
    +-- public/ <-- Document root!
    |   +-- [mini-app-1]/
    |   |   +-- index.php <-- initialize Slim here!
    |   +-- [mini-app-2]/
    |   |   +-- index.php <-- initialize Slim here!
    ```

* Ensure folders under `apps/[mini-app-name]/var/` directory are writable for your web server user/group, such as log, cache and temp.


## Folder Structure
* **apps/**
  * **[mini-app-1]/** <-- application folder (see below for detail)
    * controllers/ - controller classes
    * models/ - model classes
    * views/ - template files
    * routers/ - Slim routes group by feature, should be named as *name.router.php*
    * middlewares/ - Slim customized middleware classes
    * etc/ - configuration file, e.g. production.php, development.php
    * var/ - writable folder, such as logs, caches, temp and so on
  * **[mini-app-2]/**
    * ...
  * ...
* **lib/** - your customized lib classes against with the official composer classes in [PSR-4 standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md)
* **public/** - document root & the public assetic files, such as images, css and js
    * **[mini-app-1]/**
      * index.php   <-- initialize Slim here!
    * **[mini-app-2]/**
      * index.php   <-- initialize Slim here!
    * ...

### application folder
Here should be the main folder which stores your own codes, such as controllers, models, views, middlewares and so on.

#### routers
Slim routes group by feature, and names in **[name].router.php** format. 
different with the [Slim official example](http://docs.slimframework.com/#Routing-Overview), we using `<namespace>\<class_name>:<method_name>` format to define a route callable, against with uing Clouse in Slim official doc.

**v1.default.router.php**

```php
// default index action, GET /
$app->get('/', 'Sample\Controller\IndexController:actionIndex')
    ->name('get-homepage');

$app->group('/v1', function () use ($app) {
    // get programmers list, GET /v1/programmers
    $app->get('/programmers', 'Sample\Controller\ProgrammerController:actionGetProgrammers')
        ->name('get-programmers-list');

    // get programmer detail, GET /v1/programmers/:id
    $app->get('/programmers/:id', 'Sample\Controller\ProgrammerController:actionGetProgrammer')
        ->conditions(array('id' => '\d+'))
        ->name('get-programmer-detail');
});
```

> 1. router files are loaded & sorted in alphanumeric order, so you can priority routers by proper file names, such as,
     v1.default.router.php, v1.xxx.router.php (Thanks [Wout's comments](https://github.com/zacao/slimvc/issues/1))

> 2. call controllers with namespace is strongly recommend

#### controllers
Stores controller classes files which defined in router. It MUST be one class per file, and the filename should be same as the controller class name.

**IndexController.php**

```php
namespace Sample\Controller;

use Slimvc\Core\Controller;

class IndexController extends Controller
{
    /**
     * Default index action
     */
    public function actionIndex()
    {
        $this->getApp()->contentType('text/html');

        $data = array(
            'title' => 'It works!',
            'content' => 'Have fun with Slim framework in MVC way!'
        );

        $this->render("index/index.phtml", $data);
    }
}
```

#### configurations(etc)
Same as the Slim configuration format, please refer to the original [Slim configuration doc](http://docs.slimframework.com/#Configuration-Overview)

**development.php**

```php
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
ini_set('log_errors', true);
ini_set('html_errors', 1);
error_reporting(E_ALL | E_STRICT); // with E_STRICT for PHP 5.3 compatibility

return array(
    'debug' => true,

    // Templates settings
    'templates.path' => APP_DIR . '/views',

    // Logging settings
    'logs.level' => Slim\Log::DEBUG,

    // PDO database settings
    'pdo' => array(
        'default' => array(
            'dsn' => 'mysql:host=localhost;dbname=sample',
            'username' => 'root',
            'password' => '',
            'options' => array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
            )
        ),
    ),
);
```

#### middlewares
About the standard Slim middleware classes, Please refer to the original [Slim middleware doc](http://docs.slimframework.com/#Middleware-Overview)

#### models
The model classes should be here. You can implement the model classes as you like.

**ProgrammerModel.php**

```php
namespace Sample\Model;

use Slimvc\Core\Model;

class ProgrammerModel extends Model
{
    /**
     * Get programmer by id
     *
     * @param int $id the programmer id
     * @param array $fields the fields to be return
     *
     * @return mixed|static
     */
    public function getProgrammer($id, $fields = array())
    {
        // TODO: we just using PDO for example here, a DAL(Database Access Layer) is strongly recommended

        if ($fields && is_array($fields)) {
            // make sure the dynamical fields are safe
            foreach ($fields as $key => $field) {
                $fields[$key] = "`" . str_replace("`", "``", $field) . "`";
            }
            unset($key, $field);
            $fieldsStr = join(',', $fields);
        } else {
            $fieldsStr = '*';
        }

        $sql = 'SELECT ' . $fieldsStr . ' FROM `programmers` WHERE id = ? LIMIT 1';
        $sth = $this->getReadConnection()->prepare($sql);
        $sth->setFetchMode(\PDO::FETCH_ASSOC);
        $sth->execute(array(intval($id)));

        return $sth->fetch();
    }
}
```

#### views
Template files in default Slim format, Please refer to the original [Slim middleware doc](http://docs.slimframework.com/#View-Overview)

### var
Location for writable entries, such as logs, caches and temporary files

### lib
Put your customize classes files here, in this sample, we using PSR-4 as autoloading standard, please refer to `composer.json` and files under `lib` folder for detail.

**composer.json**

```json
"autoload": {
     "psr-4": {
         "Slimvc\\": "lib/Slimvc",
 
         "Sample\\Controller\\": "apps/sample/controllers",
         "Sample\\Model\\": "apps/sample/models",
         "Sample\\Middlewares\\": "apps/sample/middlewares"
     }
 }
```

There are Slimvc\Core\Controller, Slimvc\Core\Model sample classes created under the lib folder.

**Controller.php**

```php
namespace Slimvc\Core;

abstract class Controller
{
    protected $appName = "default";
    protected $config = array();

    /**
     * Gets the Slim Application instance
     *
     * @return \Slim\Slim
     */
    protected function getApp()
    {
        return \Slim\Slim::getInstance($this->appName);
    }

    /**
     * Gets the configuration instance of the related Slim Application
     *
     * @return array
     */
    protected function getConfig()
    {
        return $this->config;
    }

    /**
     * Constructor
     *
     * @param array $config the configurations
     */
    public function __construct($config = array())
    {
        $this->config = $this->getApp()->container['settings'];

        if ($config && is_array($config)) {
            $this->config = array_merge($config, $this->config);
        }
    }

    /**
     * Render a template
     *
     * @param  string $template The name of the template passed into the view's render() method
     * @param  array  $data     Associative array of data made available to the view
     * @param  int    $status   The HTTP response status code to use (optional)
     */
    protected function render($template, $data = array(), $status = null)
    {
        $this->getApp()->render($template, $data, $status);
    }
}
```

### public
Here is the *document root* (`.htaccess` & `index.php`) and repository per mini-application for public static assets, such as images, css and javascripts 

## Packagist
<https://packagist.org/packages/zacao/slimvc>

## License
This project is released under the MIT public license.
