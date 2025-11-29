<?php
declare(strict_types=1);
namespace App;
require_once("src/View.php");

class Controller {
    private const DEFAULT_ACTION = 'list';

    private array $getData;
    private array $postData;

    public function __construct(array $getData, array $postData)
    {
        $this->getData = $getData;
        $this->postData = $postData;
    }

    public function run(): void
    {
        $viewParams = [];
        $created = false;
        $view = new View();
        $action = $this->getData['action'] ?? self::DEFAULT_ACTION;

        switch($action) {
            case 'create':
            $page = 'create';
                if (!empty($this->postData))
                {
                    $viewParams = [
                        'text' => $this->postData['title'],
                        'description' => $this->postData['description']
                    ];
                    $created = true;
                }
            $viewParams['created'] = $created;
            break;
            case 'show':
            $viewParams = [
                'title' => 'Moja notatka',
                'description' => 'Opis'
            ];
            break;
            default:
            $page = 'list';
            $viewParams['resultList'] = 'Wyświetlamy notatki :)';
            break;
        }
        $view->render($page, $viewParams);
    }
}