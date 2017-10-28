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
		$file = (new Log\DynamicLocation('directory'));
		Assert::true(mb_strlen($file->getBasename()) <= 200);
	}

	public function testNoSpecialCharactersAsFilename() {
		$file = (new Log\DynamicLocation('directory'));
		Assert::match('~^[\w\d-]+\z~i', $file->getBasename());
	}

	public function testFilenameWithDatetime() {
		$file = (new Log\DynamicLocation('directory'));
		Assert::contains(date('Y-m-d--H-i'), $file->getBasename());
	}

	public function testAppendedSlash() {
		$file = (new Log\DynamicLocation('directory'));
		Assert::contains('directory' . DIRECTORY_SEPARATOR, $file->getPathname());
	}

	public function testTwiceAppendedSlashWithRemoving() {
		$file = (new Log\DynamicLocation('directory/'));
		Assert::contains('directory/', $file->getPathname());
	}

	public function testUniqueFilename() {
		Assert::notSame(
			(new Log\DynamicLocation('directory'))->getPathname(),
			(new Log\DynamicLocation('directory'))->getPathname()
		);
	}
}

(new DynamicLocation())->run();
