<?php
declare(strict_types = 1);
namespace Klapuch\Log;

/**
 * One line short log
 */
final class ShortLog implements Log {
	private $exception;
	private $severity;

	public function __construct(\Throwable $exception, Severity $severity) {
		$this->exception = $exception;
		$this->severity = $severity;
	}

	public function description(): string {
		return sprintf(
			"%s\r\n",
			$this->prettify($this->exception)
		);
	}

	/**
	 * Prettified version of the exception
	 * @param \Throwable $exception
	 * @return string
	 */
	private function prettify(\Throwable $exception): string {
		return sprintf(
			'[%s] - %s - %s',
			(new \DateTimeImmutable())->format('Y-m-d H:i:s'),
			$this->severity->level(),
			$exception->getMessage()
		);
	}
}