<?php
declare(strict_types=1);
namespace App;

use App\Exception\ConfigurationException;

require_once("View.php");
require_once("Database.php");
require_once("Exception\ConfigurationException.php");

class Controller {
    private const DEFAULT_ACTION = 'list';

    private Database $database;

    private array $request;
    private View $view;
    private static array $configuration = [];

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function __construct(array $request)
    {
        if(empty(self::$configuration['db']))
        {
            throw new ConfigurationException();
        }
        $this->database = new Database(self::$configuration['db']);

        $this->request = $request;
        $this->view = new View();
    }

    public function run(): void
    {
        $data = $this->getRequestPost();

        $viewParams = [];

        switch($this->action()) {
            case 'create':
            $page = 'create';
                if (!empty($data))
                {
                    $noteData = [
                        'title' => $data['title'],
                        'description' => $data['description']
                    ];
                    $this->database->createNote($noteData);
                    header('Location: /?before=created');
                }
            break;
            case 'show':
            $viewParams = [
                'title' => 'Moja notatka',
                'description' => 'Opis'
            ];
            break;
            default:
            $page = 'list';
            $data = $this->getRequestGet();

            $notes = $this->database->getNotes();
            dump($notes);

            $viewParams['before'] = $data['before'] ?? null;
            break;
        }
        $this->view->render($page, $viewParams);
    }

    private function action():string
    {
        $data = $this->getRequestGet();
        return $data['action'] ?? self::DEFAULT_ACTION;
    }

    private function getRequestGet(): array
    {
        return $this->request['get'] ?? [];
    }

    private function getRequestPost(): array
    {
        return $this->request['post'] ?? [];
    }
}