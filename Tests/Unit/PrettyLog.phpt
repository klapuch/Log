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

final class PrettyLog extends Tester\TestCase {
	public function testIncludedDatetime() {
		Assert::contains(
			(new \DateTime())->format('Y-m-d H:i'),
			(new Log\PrettyLog(
				new \Exception('error'),
				new Log\FakeSeverity('***SEVERITY***')
			))->description()
		);
	}

	public function testIncludedSeverity() {
		Assert::contains(
			'***SEVERITY***',
			(new Log\PrettyLog(
				new \Exception('error'),
				new Log\FakeSeverity('***SEVERITY***')
			))->description()
		);
	}

	public function testLogWithoutMessage() {
		Assert::contains(
			'No message was provided',
			(new Log\PrettyLog(
				new \Exception(''),
				new Log\FakeSeverity('***SEVERITY***')
			))->description()
		);
	}

	public function testLogWithoutCode() {
		Assert::contains(
			'- 0 - ',
			(new Log\PrettyLog(
				new \Exception(''),
				new Log\FakeSeverity('***SEVERITY***')
			))->description()
		);
	}

	public function testSpaceBetweenDescriptionAndTrace() {
		Assert::match(
			'~^.+[\r\n]{2}.+[\w\W^]+\z~',
			(new Log\PrettyLog(
				new \Exception(),
				new Log\FakeSeverity('***SEVERITY***')
			))->description()
		);
	}

	public function testIncludedTrace() {
		$description = (new Log\PrettyLog(
			new \Exception(),
			new Log\FakeSeverity('***SEVERITY***')
		))->description();
		Assert::contains(
			'#0 [internal function]: Klapuch\Log\Unit\PrettyLog->testIncludedTrace()',
			$description
		);
		Assert::contains('#4 {main}', $description);
	}
}

(new PrettyLog())->run();