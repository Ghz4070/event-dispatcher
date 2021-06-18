<?php

declare(strict_types=1);

namespace App\Controller;


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
