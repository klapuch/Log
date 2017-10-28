<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Log\Integration;

use Klapuch\Log;
use Klapuch\Log\TestCase;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class DirectoryLocation extends TestCase\Filesystem {
	public function testThrowingOnUnknownFilename() {
		Assert::exception(
			function() {
				(new Log\DirectoryLocation(new \SplFileInfo('foo')))->path();
			},
			\InvalidArgumentException::class,
			'Path to directory "foo" does not exist'
		);
	}

	public function testThrowingOnFileInsteadOfDirectory() {
		$filename = Tester\FileMock::create('');
		Assert::exception(
			function() use ($filename) {
				(new Log\DirectoryLocation(new \SplFileInfo($filename)))->path();
			},
			\InvalidArgumentException::class,
			sprintf('"%s" is not a directory or is not writable', $filename)
		);
	}

	public function testDirectory() {
		Assert::equal(
			new \SplFileInfo(__DIR__),
			(new Log\DirectoryLocation(new \SplFileInfo(__DIR__)))->path()
		);
	}
}

(new DirectoryLocation())->run();