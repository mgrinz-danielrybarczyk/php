<?php

declare(strict_types=1);

namespace App\Controller;

use App\Database;
use App\View;
use App\Request;
use App\Exception\ConfigurationException;

abstract class AbstractController
{
    private static array $configuration = [];
    protected const DEFAULT_ACTION = 'list';
    protected Database $database;
    protected Request $request;
    protected View $view;

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function __construct(Request $request)
    {
        if(empty(self::$configuration['db']))
        {
            throw new ConfigurationException('Configuration error');
        }
        $this->database = new Database(self::$configuration['db']);

        $this->request = $request;
        $this->view = new View();
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

    protected function redirect(string $to, array $params): void
    {
        $queryParams = [];
        $location = $to;
        if (\count($params))
        {
            foreach($params as $key => $value)
            {
                $queryParams[] = urlencode($key) .'='. urlencode($value);
            }
            $queryParams = implode('&', $queryParams);
            $location .= '?' . $queryParams;
        }
        header("Location: $location");
        exit;
    }

    private function action(): string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }
}