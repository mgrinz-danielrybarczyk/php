<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\NoteModel;
use App\Exception\NotFoundException;
use App\Exception\StorageException;
use App\View;
use App\Request;
use App\Exception\ConfigurationException;

abstract class AbstractController
{
    private static array $configuration = [];
    protected const DEFAULT_ACTION = 'list';
    protected NoteModel $noteModel;
    protected View $view;

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function __construct(protected Request $request)
    {
        if(empty(self::$configuration['db']))
        {
            throw new ConfigurationException('Configuration error');
        }
        $this->noteModel = new NoteModel(self::$configuration['db']);
        $this->view = new View();
    }

    final public function run(): void
    {
        try {
            $action = $this->action() . 'Action';
            if(!method_exists( $this, $action ))
            {
                $action = self::DEFAULT_ACTION . 'Action';
            }
            $this->$action();
        } catch(StorageException $e) {
            $this->view->render(
                'error',
                ['message' => $e->getMessage()]
            );
        } catch (NotFoundException $e) {
            $this->redirect('/', ['error' => 'noteNotFound']);
        }
        
    }

    final protected function redirect(string $to, array $params): void
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