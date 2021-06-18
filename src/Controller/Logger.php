<?php

declare(strict_types=1);

namespace App\Controller;


class Logger
{
	public function log(string $msg)
	{
		echo("\n\n $msg");
	}
}
