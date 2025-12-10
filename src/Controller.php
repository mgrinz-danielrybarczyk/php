<?php
declare(strict_types=1);
namespace App;

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use App\Request;

require_once("View.php");
require_once("Database.php");
require_once("Exception\ConfigurationException.php");
require_once("Exception\NotFoundException.php");
require_once("src/Request.php");

class Controller {
    private const DEFAULT_ACTION = 'list';
    private Database $database;
    private Request $request;
    private View $view;
    private static array $configuration = [];

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

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

    public function run(): void
    {
        switch($this->action()) {
            case 'create':
            $page = 'create';
                if ($this->request->hasPost())
                {
                    $noteData = [
                        'title' => $this->request->postParam('title'),
                        'description' => $this->request->postParam('description')
                    ];
                    $this->database->createNote($noteData);
                    header('Location: /?before=created');
                }
            break;
            case 'show':
            $page = 'show';
            $noteId = (int) $this->request->getParam('id');
            if (!$noteId)
            {
                header('Location: /?error=missingNoteId');
            }
            
            try {        
                $note = $this->database->getNote( $noteId);
            } catch (NotFoundException $e) {
                header('Location: /?error=noteNotFound');
            }
            
            $viewParams = [
                'note' => $note
            ];
            break;

            default:
            $page = 'list';
            $viewParams = [
                'before' => $this->request->getParam('before'),
                'notes' => $this->database->getNotes(),
                'error' => $this->request->getParam('error'),
            ];
            break;
        }
        $this->view->render($page, $viewParams ?? []);
    }

    private function action(): string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }
}