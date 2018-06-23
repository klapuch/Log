<?php
declare(strict_types = 1);
namespace Klapuch\Log;

final class JsonEnvironment implements Environment {
	public function post(): string {
		return json_encode($_POST);
	}

	public function get(): string {
		return json_encode($_GET);
	}

	public function session(): string {
		return json_encode($_SESSION ?? []);
	}

	public function cookie(): string {
		return json_encode($_COOKIE);
	}

	public function input(): string {
		return file_get_contents('php://input');
	}

	public function server(): string {
		return json_encode($_SERVER);
	}
}