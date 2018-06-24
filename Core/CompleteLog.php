<?php
declare(strict_types = 1);
namespace Klapuch\Log;

final class CompleteLog implements Log {
	private $logs;

	public function __construct(Log ...$logs) {
		$this->logs = $logs;
	}

	public function content(): array {
		return array_merge(
			...array_map(
				function(Log $log): array {
					return $log->content();
				},
				$this->logs
			)
		);
	}
}