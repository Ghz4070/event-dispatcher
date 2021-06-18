<?php

declare(strict_types=1);

namespace App\Controller;

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
