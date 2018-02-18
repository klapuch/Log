<?php
declare(strict_types = 1);
namespace Klapuch\Log;

final class ChainedLogs implements Logs {
	private $logs;

	public function __construct(Logs ...$logs) {
		$this->logs = $logs;
	}

	public function put(Log $log): void {
		foreach ($this->logs as $current) {
			$current->put($log);
		}
	}
}