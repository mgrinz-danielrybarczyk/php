<?php

declare(strict_types=1);

namespace App;

use App\Exception\ConfigurationException;

require_once("Exception\ConfigurationException.php");

abstract class AbstractController
{
    protected const DEFAULT_ACTION = 'list';
    protected Database $database;
    protected Request $request;
    protected View $view;
    private static array $configuration = [];

    public function __construct(Request $request)
    {
        if(empty(self::$configuration['db']))
        {
            throw new ConfigurationException();
        }
        $this->database = new Database(self::$configuration['db']);

        $this->request = $request;
        $this->view = new View();
    }

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }
    protected function action(): string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }

    public function run(): void
    {
        $action = $this->action() . 'Action';
        if(!method_exists( $this, $action ))
        {
            $action = self::DEFAULT_ACTION . 'Action';
        }
        $this->$action();
    }
}