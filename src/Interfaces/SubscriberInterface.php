<?php

declare(strict_types=1);

namespace App\Interfaces;


interface SubscriberInterface
{
	public function update(Event $subject): void;

	public static function getSubscribedEvents(): array;
}
