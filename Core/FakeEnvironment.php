<?php
declare(strict_types = 1);
namespace Klapuch\Log;

final class FakeEnvironment  implements Environment {
	public function post(): string {
		return __FUNCTION__;
	}

	public function get(): string {
		return __FUNCTION__;
	}

	public function session(): string {
		return __FUNCTION__;
	}

	public function cookie(): string {
		return __FUNCTION__;
	}

	public function input(): string {
		return __FUNCTION__;
	}

	public function server(): string {
		return __FUNCTION__;
	}
}