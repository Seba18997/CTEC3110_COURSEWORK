<?php

use M2MAPP\MessagesModel;
use M2MAPP\SoapWrapper;
use M2MAPP\Validator;

include( '/p3t/phpappfolder/includes/ctec3110coursework_private/app/src/SoapWrapper.php' );

$container['view'] = function ($container) {
  $view = new \Slim\Views\Twig(
    $container['settings']['view']['template_path'],
    $container['settings']['view']['twig'],
    [
      'debug' => true // This line should enable debug mode
    ]
  );

  // Instantiate and add Slim specific extension
  $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
  $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

  return $view;
};

$container['Validator'] = function ($container) {
  $validator = new Validator();
  return $validator;
};

$container['DisplayMessages'] = function ($container) {
    $model = new MessagesModel();
    return $model;
};

$container['SoapWrapper'] = function ($container) {
    $wrapper = new SoapWrapper();
    return $wrapper;
};