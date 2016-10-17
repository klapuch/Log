<?php
declare(strict_types = 1);
namespace Klapuch\Log;

/**
 * Logs stored on the filesystem
 */
final class FilesystemLogs implements Logs {
	private $location;

	public function __construct(string $location) {
	    $this->location = $location;
	}

	public function put(Log $log): void {
		file_put_contents(
			$this->location . DIRECTORY_SEPARATOR . $this->filename(),
			$log->description(),
			LOCK_EX
		);
	}

	/**
	 * Unique filename for the log being putted
	 * @return string
	 */
	private function filename(): string {
		return substr(
			md5(serialize($this) . base64_encode(random_bytes(5))),
			0,
			20
		) . date('Y-m-d--H-i');
	}
}