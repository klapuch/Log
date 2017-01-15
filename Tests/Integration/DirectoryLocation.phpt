<?php
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Integration\Log;

use Klapuch\Log;
use Klapuch\Log\TestCase;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class DirectoryLocation extends TestCase\Filesystem {
	public function testThrowingOnUnknownFilename() {
		Assert::exception(
			function() {
				(new Log\DirectoryLocation('foo'))->path();
			},
			\InvalidArgumentException::class,
			'Path to directory "foo" does not exist'
		);
	}

	public function testThrowingOnFileInsteadOfDirectory() {
		$filename = Tester\FileMock::create('');
		Assert::exception(
			function() use ($filename) {
				(new Log\DirectoryLocation($filename))->path();
			},
			\InvalidArgumentException::class,
			"\"$filename\" is not a directory or is not writable"
		);
	}

	public function testDirectory() {
		Assert::same(__DIR__, (new Log\DirectoryLocation(__DIR__))->path());
	}
}

(new DirectoryLocation())->run();