<?php
//Since all routing comes through here we start the session here
//And include a check because otherwise it will give ugly error(i literally mean ugly find out for yourself)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Enable error reporting and display errors (for debugging purposes)
error_reporting(E_ALL);
ini_set('display_errors', 1);


//Gets the current url set by nginx to be something like localhost/url=<page>.php
//trims it, or switches to '/' if not set.
$request = isset($_SERVER['REQUEST_URI']) ? '/' . trim($_SERVER['REQUEST_URI'], '/') : '/';
$routes = require __DIR__ . '/../routes/web.php';

if (array_key_exists($request, $routes)) {
    require __DIR__ . '/../front-end/' . $routes[$request];

} else {
    http_response_code(404);
    require __DIR__ . '/../front-end/404.php';
}
?>
