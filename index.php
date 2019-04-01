<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/classes/ViewModel.php';
require __DIR__ . '/classes/MyTwigExtension.php';

$viewData = new ViewModel();

$loader = new \Twig\Loader\FilesystemLoader('views/templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true,
    // 'cache' => '.cache',
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
$twig->addExtension(new MyTwigExtension());
$twig->addGlobal('is_amp_script', 'fuzz');

echo $twig->render('pages/index.html', ['view' => $viewData->data]);
