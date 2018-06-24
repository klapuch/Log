<?php
declare(strict_types = 1);
namespace Klapuch\Log;

interface Log {
	public function content(): array;
}