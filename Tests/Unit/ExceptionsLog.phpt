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

final class ExceptionsLog extends Tester\TestCase {
	public function testProvidedFields() {
		$content = (new Log\ExceptionsLog(
			new \RuntimeException('foo', 0, new \LogicException('bar'))
		))->content();
		Assert::same(['previous'], array_keys($content));
		Assert::same(array_keys($content['previous'][0]), ['type', 'code', 'file', 'line', 'message', 'trace']);
	}
}
(new ExceptionsLog())->run();
