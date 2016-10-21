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

final class DirectoryLogs extends TestCase\Filesystem {
	public function testLoggingToUnknownFilename() {
		Assert::exception(
			function() {
				(new Log\DirectoryLogs(
					new Log\FakeLogs(),
					'foo'
				))->put(new Log\FakeLog());
			},
			\InvalidArgumentException::class,
			'Log can not be putted, because path to "foo" does not exist'
		);
	}

	public function testLoggingToFileInsteadOfDirectory() {
		Assert::exception(
			function() {
				(new Log\DirectoryLogs(
					new Log\FakeLogs(),
					Tester\FileMock::create('')
				))->put(new Log\FakeLog());
			},
			\InvalidArgumentException::class,
			'Log can be putted only to directories'
		);
	}

	public function testLoggingToNonWritableDirectory() {
		$directory = __DIR__ . '/../Temporary/logs';
		Tester\Helpers::purge($directory);
		chmod($directory, 0555);
		Assert::exception(
			function() use ($directory) {
				(new Log\DirectoryLogs(
					new Log\FakeLogs(),
					$directory
				))->put(new Log\FakeLog());
			},
			\InvalidArgumentException::class,
			"Directory \"$directory\" is not writable"
		);
	}

	public function testLoggingToFilledDirectoryWithoutAffectingOthers() {
		$directory = __DIR__ . '/../Temporary/logs';
		Tester\Helpers::purge($directory);
		file_put_contents($directory . '/a.txt', 'This is a');
		file_put_contents($directory . '/b.txt', 'This is b');
		(new Log\DirectoryLogs(
			new Log\FakeLogs(),
			$directory
		))->put(new Log\FakeLog());
		Assert::same('This is a', file_get_contents($directory . '/a.txt'));
		Assert::same('This is b', file_get_contents($directory . '/b.txt'));
	}

	public function testLoggingToEmptyDirectory() {
		$directory = __DIR__ . '/../Temporary/logs';
		Tester\Helpers::purge($directory);
		Assert::noError(
			function() use ($directory) {
				(new Log\DirectoryLogs(
					new Log\FakeLogs(),
					$directory
				))->put(new Log\FakeLog());
			}
		);
	}
}

(new DirectoryLogs())->run();