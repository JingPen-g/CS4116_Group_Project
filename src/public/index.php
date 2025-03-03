<?php

//Gets the current url set by nginx to be something like localhost/url=<page>.php
//trims it, or switches to '/' if not set.
$request = isset($_GET['url']) ? '/' . trim($_GET['url'], '/') : '/';

$routes = require __DIR__ . '/../routes/web.php';

if (array_key_exists($request, $routes)) {
    require __DIR__ . '/../front-end/' . $routes[$request];
} else {
    http_response_code(404);
    require __DIR__ . '/../front-end/404.php';
}
