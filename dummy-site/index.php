<?php
require '../vendor/autoload.php';

$app = new \Slim\Slim(array(
    'templates.path' => 'templates'
));

$app->get('/', function () use ($app) {
    $app->render('main.php');
});

$app->get('/submitted', function () use ($app) {
    $app->render('submitted.php');
});


$app->run();