<?php
declare(strict_types = 1);
namespace Klapuch\Log;

/**
 * Logs with permission to be written
 */
final class DirectoryLogs implements Logs {
	private $origin;
	private $directory;

	public function __construct(Logs $origin, string $director) {
		$this->origin = $origin;
		$this->directory = $director;
	}

	public function put(Log $log): void {
		if(!file_exists($this->directory)) {
			throw new \InvalidArgumentException(
				sprintf(
					'Log can not be putted, because path to "%s" does not exist',
					$this->directory
				)
			);
		} elseif(!is_dir($this->directory)) {
			throw new \InvalidArgumentException(
				'Logs can be putted only to directories'
			);
		} elseif(!is_writable($this->directory)) {
			throw new\InvalidArgumentException(
				sprintf(
					'Directory "%s" is not writable',
					$this->directory
				)
			);
		}
		$this->origin->put($log);
	}
}