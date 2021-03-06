<?php

<<<<<<< HEAD
// Load configuration
$config = new GitList\Config('config.ini');
=======
if (!isset($config)) {
    die("No configuration object provided.");
}

>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
$config->set('git', 'repositories', rtrim($config->get('git', 'repositories'), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR);

// Startup and configure Silex application
$app = new GitList\Application($config, __DIR__);

// Mount the controllers
$app->mount('', new GitList\Controller\MainController());
$app->mount('', new GitList\Controller\BlobController());
$app->mount('', new GitList\Controller\CommitController());
$app->mount('', new GitList\Controller\TreeController());

return $app;
