<?php
use Slimvc\Core\Controller;

class IndexController extends Controller
{
    public function index()
    {
        var_dump(__METHOD__);

        $data = array(
            'title' => 'It works!',
            'content' => 'Just have fun with the Slim in MVC way now!'
        );

        $this->render("index/index.phtml", $data);
    }
}