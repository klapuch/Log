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

final class ShortLog extends Tester\TestCase {
	public function testIncludedDatetime() {
		Assert::contains(
			sprintf('[%s]', (new \DateTime())->format('Y-m-d H:i:s')),
			(new Log\ShortLog(
				new \Exception('error'),
				new Log\FakeSeverity('***SEVERITY***')
			))->description()
		);
	}

	public function testIncludedSeverity() {
		Assert::contains(
			'***SEVERITY***',
			(new Log\ShortLog(
				new \Exception('error'),
				new Log\FakeSeverity('***SEVERITY***')
			))->description()
		);
	}

	public function testLogWithoutMessage() {
		Assert::contains(
			'- ',
			(new Log\ShortLog(
				new \Exception(''),
				new Log\FakeSeverity('***SEVERITY***')
			))->description()
		);
	}

	public function testSpaceAfter() {
		Assert::match(
			'~.+\r\n\z~',
			(new Log\ShortLog(
				new \Exception(),
				new Log\FakeSeverity('***SEVERITY***')
			))->description()
		);
	}
}

(new ShortLog())->run();