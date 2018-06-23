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

final class FilesystemLogs extends TestCase\Filesystem {
	private const LOGS = __DIR__ . '/../Temporary/logs';

	public function setUp() {
		parent::setUp();
		Tester\Helpers::purge(self::LOGS);
	}

	public function testFormat() {
		(new Log\FilesystemLogs(
			new \SplFileInfo(self::LOGS . '/a.txt')
		))->put(
			new \RuntimeException('foo'),
			new Log\FakeEnvironment()
		);
		Assert::same(
			preg_replace('~^\[.+\]~', '[2010-01-01 01:01]', file_get_contents(self::LOGS . '/a.txt')),
			file_get_contents(__DIR__ . '/snapshots/format.txt')
		);
	}
}

(new FilesystemLogs())->run();