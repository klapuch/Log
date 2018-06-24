<?php
declare(strict_types = 1);
namespace Klapuch\Log;

final class ExceptionLog implements Log {
	private $exception;

	public function __construct(\Throwable $exception) {
		$this->exception = $exception;
	}

	public function content(): array {
		return [
			'type' => get_class($this->exception),
			'code' => $this->exception->getCode(),
			'file' => $this->exception->getFile(),
			'line' => $this->exception->getLine(),
			'message' => $this->exception->getMessage(),
			'trace' => $this->exception->getTraceAsString(),
		];
	}
}