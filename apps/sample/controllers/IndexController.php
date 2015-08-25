<?php
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
