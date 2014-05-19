<?php
require '../vendor/autoload.php';

$app = new \Slim\Slim(array(
    'templates.path' => 'templates'
));

$app->get('/', function () use ($app) {
    $app->render('main.php');
});


$app->run();