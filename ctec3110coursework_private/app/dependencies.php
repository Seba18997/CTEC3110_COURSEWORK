<?php

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

$container['Helper'] = function ($container) {
  $helper = new M2MAPP\Helper();
  return $helper;
};

$container['DisplayMessages'] = function ($container) {
    $model = new M2MAPP\MessagesModel();
    return $model;
};

$container['SoapWrapper'] = function ($container) {
    $swrapper = new M2MAPP\SoapWrapper();
    return $swrapper;
};

$container['DatabaseWrapper'] = function ($container) {
    $dwrapper = new M2MAPP\DatabaseWrapper();
    return $dwrapper;
};

$container['SQLQueries'] = function ($container) {
    $queries = new M2MAPP\SQLQueries();
    return $queries;
};

$container['Validator'] = function ($container) {
    $validator = new M2MAPP\Validator();
    return $validator;
};

$container['DownloadMessagesToDatabase'] = function ($container) {
    $downloader = new M2MAPP\DownloadMessagesToDatabase();
    return $downloader;
};

$container['Decoder'] = function ($container) {
    $decoder = new M2MAPP\Decoder();
    return $decoder;
};

$container['SwitchModel'] = function ($container) {
    $smodel = new M2MAPP\SwitchModel();
    return $smodel;
};

$container['processOutput'] = function ($container) {
    $process = new M2MAPP\ProcessOutput();
    return $process;
};

$container['doctrineSqlQueries'] = function ($container) {
    $doctrine_sql_queries = new \M2MAPP\DoctrineSqlQueries();
    return $doctrine_sql_queries;
};

$container['libSodiumWrapper'] = function ($container)
{
    $wrapper = new \M2MAPP\LibSodiumWrapper();
    return $wrapper;
};