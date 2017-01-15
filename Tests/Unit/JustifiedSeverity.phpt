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

final class JustifiedSeverity extends Tester\TestCase {
	public function testJustifiedSeverity() {
		Assert::same(
			Log\Severity::ERROR,
			(new Log\JustifiedSeverity(Log\Severity::ERROR))->level()
		);
	}

	public function testThrowingOnUnknownSeverity() {
		Assert::exception(
			function() {
				(new Log\JustifiedSeverity('foo'))->level();
			},
			\InvalidArgumentException::class,
			'Justified levels for severity are INFO, WARNING, ERROR - "foo" given '
		);
	}

	public function testThrowingOnCaseInsensitiveSeverity() {
		Assert::exception(
			function() {
				(new Log\JustifiedSeverity(
					strtolower(Log\Severity::ERROR)
				))->level();
			},
			\InvalidArgumentException::class,
			'Justified levels for severity are INFO, WARNING, ERROR - "error" given '
		);
	}
}

(new JustifiedSeverity())->run();