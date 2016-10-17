<?php
/**
 * @testCase
 * @phpVersion > 7.1
 */
namespace Klapuch\Unit\Log;

use Klapuch\Log;
use Tester;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

final class PrettySeverity extends Tester\TestCase {
	public function testInfoFormat() {
		Assert::same(
			'? INFO ?',
			(new Log\PrettySeverity(
				new Log\FakeSeverity(Log\Severity::INFO)
			))->level()
		);
	}

	public function testWarningFormat() {
		Assert::same(
			'# WARNING #',
			(new Log\PrettySeverity(
				new Log\FakeSeverity(Log\Severity::WARNING)
			))->level()
		);
	}

	public function testErrorFormat() {
		Assert::same(
			'! ERROR !',
			(new Log\PrettySeverity(
				new Log\FakeSeverity(Log\Severity::ERROR)
			))->level()
		);
	}

	public function testEmptySeverityWithNotice() {
		Assert::same(
			'| UNSPECIFIED |',
			(new Log\PrettySeverity(
				new Log\FakeSeverity('')
			))->level()
		);
	}

	public function testUnknownSeverityWithDefaultFormat() {
		Assert::same(
			'| foo |',
			(new Log\PrettySeverity(
				new Log\FakeSeverity('foo')
			))->level()
		);
	}
}

(new PrettySeverity())->run();
