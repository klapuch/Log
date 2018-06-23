<?php
declare(strict_types = 1);
namespace Klapuch\Log;

/**
 * Fake
 */
final class FakeLog implements Log {
	private $message;
	private $trace;
	private $environment;

	public function __construct(
		string $message = null,
		string $trace = null,
		Environment $environment = null
	) {
		$this->message = $message;
		$this->trace = $trace;
		$this->environment = $environment;
	}

	public function message(): string {
		return $this->message;
	}

	public function trace(): string {
		return $this->trace;
	}

	public function environment(): Environment {
		return $this->environment;
	}
}