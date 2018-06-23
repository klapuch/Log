<?php
declare(strict_types = 1);
namespace Klapuch\Log;

interface Environment {
	public function post(): array;
	public function get(): array;
	public function session(): array;
	public function cookie(): array;
	public function input(): string;
	public function server(): array;
}