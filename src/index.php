<?php

declare(strict_types=1);

interface Subscriber
{
	public function update(Event $subject): void;

	public static function getSubscribedEvents(): array;
}

interface Event
{

}

class Notifier
{
	private $subscribers = [];

	public function __construct(Subscriber ...$subscribers)
	{
		foreach ($subscribers as $subscriber) {
			foreach ($subscriber::getSubscribedEvents() as $event) {
				$this->subscribers[$event][] = $subscriber;
			}
		}
	}

	public function notify(Event $event)
	{
		$eventName = get_class($event);

		if (isset($this->subscribers[$eventName]) === false) {
			return;
		}

		$subscribers = $this->subscribers[$eventName];

		/** @var Subscriber $subscriber */
		foreach ($subscribers as $subscriber) {
			$subscriber->update($event);
		}
	}
}

class Logger
{
	public function log(string $msg)
	{
		echo("\n\n $msg");
	}
}

class LoggerSubscriber implements Subscriber
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

class Controller
{
	private $notifier;

	public function __construct(Notifier $notifier)
	{
		$this->notifier = $notifier;
	}

	public function __invoke(string $string)
	{
		$this->notifier->notify(new Pre);

		echo($string);

		$this->notifier->notify(new Post);
	}
}

class Pre implements Event
{

}

class Post implements Event
{

}

$logger = new Logger();

$subscribers = [
	new LoggerSubscriber($logger),
	new LoggerSubscriber($logger),
];

$notifier = new Notifier(...$subscribers);

$controller = new Controller($notifier);

$controller->__invoke("\n hello world");
