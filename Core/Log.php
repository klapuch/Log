<?php
declare(strict_types = 1);
namespace Klapuch\Log;

interface Log {
	public function message(): string;
	public function trace(): string;
	public function environment(): Environment;
}