<?php
declare(strict_types = 1);
namespace Klapuch\Log;

final class CurrentEnvironment implements Environment {
	public function post(): array {
		return $_POST;
	}

	public function get(): array {
		return $_GET;
	}

	public function session(): array {
		return $_SESSION ?? [];
	}

	public function cookie(): array {
		return $_COOKIE;
	}

	public function input(): string {
		return file_get_contents('php://input');
	}

	public function server(): array {
		return $_SERVER;
	}
}