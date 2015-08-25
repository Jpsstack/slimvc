<?php
namespace Admin;

use Slimvc\Core\Controller;

class ArticleController extends Controller
{
    public function get($id)
    {
        var_dump(__METHOD__);
        $config = $this->getConfig();

        $model = new \ArticleModel($config);
        $ret = $model->getById($id);

        var_dump($ret);
    }
}