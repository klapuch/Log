<?php
declare(strict_types = 1);
namespace Klapuch\Log;

/**
 * Location with a dynamic filename
 */
final class DynamicLocation extends \SplFileInfo {
	public function __construct(string $filename) {
		parent::__construct(
			$filename . DIRECTORY_SEPARATOR . substr(
				md5(uniqid() . base64_encode(random_bytes(5))),
				0,
				20
			) . date('Y-m-d--H-i')
		);
	}
}