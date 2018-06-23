<?php
declare(strict_types = 1);
namespace Klapuch\Log;

/**
 * Log as json
 */
final class JsonLog implements Log {
	private $exception;

	public function __construct(\Throwable $exception) {
		$this->exception = $exception;
	}

	public function message(): string {
		return $this->exception->getMessage();
	}

	public function trace(): string {
		return $this->exception->getTraceAsString();
	}

	public function environment(): Environment {
		return new JsonEnvironment();
	}
}