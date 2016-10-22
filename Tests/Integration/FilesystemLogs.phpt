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

final class FilesystemLogs extends TestCase\Filesystem {
	private const LOGS = __DIR__ . '/../Temporary/logs';
	private const LOG = self::LOGS . '/log.txt';
	private const LOG_FILES = self::LOGS . '/*';

	public function setUp() {
		parent::setUp();
		Tester\Helpers::purge(self::LOGS);
	}

	public function testLoggingToEmptyDirectory() {
		(new Log\FilesystemLogs(
			new Log\FakeLocation(self::LOG)
		))->put(new Log\FakeLog('foo'));
		Assert::true(is_file(self::LOG));
	}

	public function testLoggingMultipleTimesWithoutRewriting() {
		(new Log\FilesystemLogs(
			new Log\FakeLocation(self::LOGS . '/a.txt')
		))->put(new Log\FakeLog('foo'));
		(new Log\FilesystemLogs(
			new Log\FakeLocation(self::LOGS . '/b.txt')
		))->put(new Log\FakeLog('bar'));
		Assert::count(2, glob(self::LOG_FILES));
		Assert::same('foo', file_get_contents(self::LOGS . '/a.txt'));
		Assert::same('bar', file_get_contents(self::LOGS . '/b.txt'));
	}

	public function testAvailableAppending() {
		$logs = new Log\FilesystemLogs(new Log\FakeLocation(self::LOG));
		$logs->put(new Log\FakeLog('First'));
		$logs->put(new Log\FakeLog('Second'));
		Assert::count(1, glob(self::LOG_FILES));
		Assert::same('FirstSecond', file_get_contents(self::LOG));
	}

	public function testLoggingToFilledDirectoryWithoutAffectingOthers() {
		file_put_contents(self::LOGS . '/a', 'This is a');
		file_put_contents(self::LOGS . '/b', 'This is b');
		Assert::count(2, glob(self::LOG_FILES));
		(new Log\FilesystemLogs(
			new Log\FakeLocation(self::LOG)
		))->put(new Log\FakeLog('foo'));
		Assert::count(3, glob(self::LOG_FILES));
		Assert::same('This is a', file_get_contents(self::LOGS . '/a'));
		Assert::same('This is b', file_get_contents(self::LOGS . '/b'));
	}
}

(new FilesystemLogs())->run();