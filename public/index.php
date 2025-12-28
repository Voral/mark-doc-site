<?php

//echo "1";
/*var_dump(file_put_contents('/media/alex/Speed/htdocs/vidoc/public/test.php', '<?php die("Maintenance mode"); ?>'));*/
/*var_dump(file_put_contents('/media/alex/Speed/htdocs/vidoc/test.php', '<?php die("Maintenance mode"); ?>'));*/
/*var_dump(file_put_contents('/media/alex/Speed/htdocs/vidoc/storage/test.php', '<?php die("Maintenance mode"); ?>'));*/
/*var_dump(file_put_contents('/media/alex/Speed/htdocs/vidoc/storage/logs/test.php', '<?php die("Maintenance mode"); ?>'));*/
//die();

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
