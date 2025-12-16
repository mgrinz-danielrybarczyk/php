<?php

declare(strict_types=1);

spl_autoload_register(function (string $classNamespace){
    $path = str_replace(['App', '\\'], ['', '/'], $classNamespace);
    $path = "src/$path.php";
    require_once($path);
});

use App\Request;
use App\Exception\AppException;
use App\Exception\ConfigurationException;
use App\Controller\AbstractController;
use App\Controller\NoteController;

require_once("src/Utils/debug.php");

$configuration = require_once("config/config.php");
$request = new Request($_GET, $_POST);

try {
    AbstractController::initConfiguration($configuration);
    (new NoteController($request))->run();
} catch (ConfigurationException $e) {
    dump($e);
    echo '<h1>Wystąpił problem z konfiguracją.</br>Skontaktuj się z administratorem: daniel@admin.pl</h1';

} catch (AppException $e) {
    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    echo '<h3>' . $e->getMessage() . '</h3>';

} catch (\Throwable $e) {
    echo '<h1>Wystąpił błąd Throwable</h1>';
    dump($e);
}
