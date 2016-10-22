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
	private const LOG_FILES = self::LOGS . '/*';

	public function setUp() {
		parent::setUp();
		Tester\Helpers::purge(self::LOGS);
	}

	public function testLoggingToEmptyDirectory() {
		(new Log\FilesystemLogs(self::LOGS))->put(new Log\FakeLog('foo'));
		Assert::count(1, glob(self::LOG_FILES));
	}

	public function testFilenameLength() {
		(new Log\FilesystemLogs(self::LOGS))->put(new Log\FakeLog('foo'));
		Assert::true(mb_strlen(current(glob(self::LOG_FILES))) <= 200);
	}

	public function testNoSpecialCharactersAsFilename() {
		(new Log\FilesystemLogs(self::LOGS))->put(new Log\FakeLog('foo'));
		Assert::match(
			'~^[\w\d-]+\z~i',
			basename(current(glob(self::LOG_FILES)))
		);
	}

	public function testFilenameWithDatetime() {
		(new Log\FilesystemLogs(self::LOGS))->put(new Log\FakeLog('foo'));
		$log = basename(current(glob(self::LOG_FILES)));
		Assert::contains(date('Y-m-d--H-i'), $log);
	}

	public function testLoggingMultipleSameErrorsWithoutRewriting() {
		$logs = new Log\FilesystemLogs(self::LOGS);
		$log = new Log\FakeLog('foo');
		$logs->put($log);
		$logs->put($log);
		Assert::count(2, glob(self::LOG_FILES));
	}

	public function testLoggingMultipleDifferentErrorsWithoutRewriting() {
		$logs = new Log\FilesystemLogs(self::LOGS);
		$logs->put(new Log\FakeLog('foo'));
		$logs->put(new Log\FakeLog('bar'));
		Assert::count(2, glob(self::LOG_FILES));
	}

	public function testLoggingToFilledDirectoryWithoutAffectingOthers() {
		file_put_contents(self::LOGS . '/a', 'This is a');
		file_put_contents(self::LOGS . '/b', 'This is b');
		Assert::count(2, glob(self::LOG_FILES));
		(new Log\FilesystemLogs(self::LOGS))->put(new Log\FakeLog('foo'));
		Assert::count(3, glob(self::LOG_FILES));
		Assert::same('This is a', file_get_contents(self::LOGS . '/a'));
		Assert::same('This is b', file_get_contents(self::LOGS . '/b'));
	}
}

(new FilesystemLogs())->run();