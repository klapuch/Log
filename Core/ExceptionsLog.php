<?php
declare(strict_types = 1);
namespace Klapuch\Log;

final class ExceptionsLog implements Log {
	private $exception;

	public function __construct(\Throwable $exception) {
		$this->exception = $exception;
	}

	public function content(): array {
		return [
			'previous' => array_map(
				function (\Throwable $exception): array {
					return (new ExceptionLog($exception))->content();
				},
				iterator_to_array((new PreviousExceptions($this->exception)))
			),
		];
	}
}