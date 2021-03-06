<?php
declare(strict_types = 1);
namespace Klapuch\Log;

final class FakeEnvironment  implements Environment {
	public function post(): array {
		return [__FUNCTION__];
	}

	public function get(): array {
		return [__FUNCTION__];
	}

	public function session(): array {
		return [__FUNCTION__];
	}

	public function cookie(): array {
		return [__FUNCTION__];
	}

	public function input(): string {
		return __FUNCTION__;
	}

	public function server(): array {
		return [__FUNCTION__];
	}
}