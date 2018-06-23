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
			new Log\FakeEnvironment(),
			new \DateTimeImmutable('2005-01-01 10:00')
		);
		Assert::same(
			file_get_contents(__DIR__ . '/snapshots/format.txt'),
			file_get_contents(self::LOGS . '/a.txt')
		);
	}
}

(new FilesystemLogs())->run();