<?php
declare(strict_types = 1);
namespace Klapuch\Log;

/**
 * Detailed log
 */
final class DetailedLog implements Log {
	private $exception;
	private $severity;

	public function __construct(\Throwable $exception, Severity $severity) {
		$this->exception = $exception;
		$this->severity = $severity;
	}

	public function description(): string {
		return sprintf(
			"%s\r\n%s\r\n\r\n%s",
			(new ShortLog($this->exception, $this->severity))->description(),
			$this->exception->getTraceAsString(),
			$this->print('$_SERVER', $_SERVER)
				. $this->print('$_SESSION', $_SESSION ?? [])
				. $this->print('$_COOKIE', $_COOKIE)
				. $this->print('$_POST', $_POST)
				. $this->print('$_GET', $_GET)
		);
	}


	private function print(string $name, array $part): string
	{
		return sprintf("%s:\r\n%s\r\n\r\n", $name, var_export($part, true));
	}
}