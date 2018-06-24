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

final class PreviousExceptions extends Tester\TestCase {
	public function testAllPreviousExceptions() {
		Assert::equal(
			[
				'RuntimeException',
				'DomainException',
				'LogicException',
			],
			array_map(
				'get_class',
				iterator_to_array(
					new Log\PreviousExceptions(
						new \UnexpectedValueException(
							'',
							0,
							new \RuntimeException(
								'a',
								0,
								new \DomainException(
									'b',
									1,
									new \LogicException('c')
								)
							)
						)
					)
				)
			)
		);
	}

	public function testPassingOnNoPrevious() {
		Assert::equal(
			[],
			iterator_to_array(
				new Log\PreviousExceptions(
					new \LogicException('c')
				)
			)
		);
	}
}
(new PreviousExceptions())->run();
