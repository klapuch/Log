<?php
declare(strict_types = 1);
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Log\Unit;

use Klapuch\Log;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class DynamicLocation extends Tester\TestCase {
	public function testFilenameLength() {
		$path = (new Log\DynamicLocation(
			new Log\FakeLocation('directory')
		))->path();
		Assert::true(mb_strlen(basename($path)) <= 200);
	}

	public function testNoSpecialCharactersAsFilename() {
		$path = (new Log\DynamicLocation(
			new Log\FakeLocation('directory')
		))->path();
		Assert::match('~^[\w\d-]+\z~i', basename($path));
	}

	public function testFilenameWithDatetime() {
		$path = (new Log\DynamicLocation(
			new Log\FakeLocation('directory')
		))->path();
		Assert::contains(date('Y-m-d--H-i'), $path);
	}

	public function testAppendedSlash() {
		$path = (new Log\DynamicLocation(
			new Log\FakeLocation('directory')
		))->path();
		Assert::contains('directory' . DIRECTORY_SEPARATOR, $path);
	}

	public function testTwiceAppendedSlashWithoutRemoving() {
		$path = (new Log\DynamicLocation(
			new Log\FakeLocation('directory/')
		))->path();
		Assert::contains('directory/' . DIRECTORY_SEPARATOR, $path);
	}

	public function testUniqueFilename() {
		Assert::notSame(
			(new Log\DynamicLocation(
				new Log\FakeLocation('directory')
			))->path(),
			(new Log\DynamicLocation(
				new Log\FakeLocation('directory')
			))->path()
		);
	}
}

(new DynamicLocation())->run();
