<?php
declare(strict_types = 1);
namespace Klapuch\Log;

/**
 * All previous exception from the root
 */
final class PreviousExceptions implements \IteratorAggregate {
	private $root;

	public function __construct(\Throwable $root) {
		$this->root = $root;
	}

	public function getIterator(): \ArrayIterator {
		return new \ArrayIterator($this->previous($this->root->getPrevious()));
	}

	private function previous(?\Throwable $e): array {
		static $exceptions = [];
		if ($e === null)
			return $exceptions;
		$exceptions[] = $e;
		return $this->previous($e->getPrevious());
	}
}