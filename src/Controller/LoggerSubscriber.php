<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Subscriber as Subscriber;

class LoggerSubscriber extends Subscriber
{
	private $logger;

	public function __construct(Logger $logger)
	{
		$this->logger = $logger;
	}

	public function update(Event $subject): void
	{
		$this->logger->log(get_class($subject));
	}

	public static function getSubscribedEvents(): array
	{
		return [Pre::class, Post::class];
	}
}
