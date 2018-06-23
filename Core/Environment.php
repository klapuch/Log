<?php
declare(strict_types = 1);
namespace Klapuch\Log;

interface Environment {
	public function post(): string;
	public function get(): string;
	public function session(): string;
	public function cookie(): string;
	public function input(): string;
	public function server(): string;
}