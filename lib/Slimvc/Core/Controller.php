<?php
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