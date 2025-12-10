<?php

declare(strict_types=1);

namespace App;

use App\Exception\AppException;
use App\Exception\ConfigurationException;
use Throwable;
use App\Request;

require_once("src/Utils/debug.php");
require_once("src/Controller.php");
require_once("src/Request.php");

$configuration = require_once("config/config.php");

$request = new Request($_GET, $_POST);

try {
    Controller::initConfiguration($configuration);
    (new Controller($request))->run();
} catch (ConfigurationException $e) {
    dump($e);
    echo '<h1>Wystąpił problem z konfiguracją.</br>Skontaktuj się z administratorem: daniel@admin.pl</h1';

} catch (AppException $e) {
    echo '<h1>Wystąpił błąd w aplikacji</h1>';
    echo '<h3>' . $e->getMessage() . '</h3>';

} catch (Throwable $e) {
    echo '<h1>Wystąpił błąd Throwable</h1>';
    dump($e);
}
