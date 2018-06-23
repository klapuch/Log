<?php
declare(strict_types = 1);
namespace Klapuch\Log;

final class DumpedEnvironment implements Environment {
	public function post(): string {
		return var_export($_POST, true);
	}

	public function get(): string {
		return var_export($_GET, true);
	}

	public function session(): string {
		return var_export($_SESSION ?? [], true);
	}

	public function cookie(): string {
		return var_export($_COOKIE, true);
	}

	public function input(): string {
		return file_get_contents('php://input');
	}

	public function server(): string {
		return var_export($_SERVER, true);
	}
}