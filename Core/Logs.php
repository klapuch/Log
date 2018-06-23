<?php
declare(strict_types = 1);
namespace Klapuch\Log;

interface Logs {
	public function put(Log $log): void;
}