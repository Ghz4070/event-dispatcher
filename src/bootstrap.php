<?php

use App\Controller\Controller;
use App\Controller\Logger;
use App\Controller\LoggerSubscriber;
use App\Controller\Notifier;

require "vendor/autoload.php";

$logger = new Logger();

$subscribers = [
	new LoggerSubscriber($logger),
	new LoggerSubscriber($logger),
];

$notifier = new Notifier(...$subscribers);

$controller = new Controller($notifier);

$controller->__invoke("\n hello world");
