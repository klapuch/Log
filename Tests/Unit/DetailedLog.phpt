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

final class DetailedLog extends Tester\TestCase {
	public function testIncludedTrace() {
		$description = (new Log\DetailedLog(
			new \Exception(),
			new Log\FakeSeverity('***SEVERITY***')
		))->description();
		Assert::contains(
			'#0 [internal function]: Klapuch\Log\Unit\DetailedLog->testIncludedTrace()',
			$description
		);
		Assert::contains('#4 {main}', $description);
	}
}

(new DetailedLog())->run();