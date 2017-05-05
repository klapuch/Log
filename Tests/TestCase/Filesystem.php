<?php
declare(strict_types = 1);
namespace Klapuch\Log\TestCase;

use Tester;

abstract class Filesystem extends Tester\TestCase {
	private const TEMPORARY = __DIR__ . '/../Temporary';

	protected function setUp() {
		parent::setUp();
		Tester\Environment::lock('filesystem', self::TEMPORARY);
		$files = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator(self::TEMPORARY)
		);
		foreach ($files as $file)
			chmod($file->getPathName(), 0777);
	}
}